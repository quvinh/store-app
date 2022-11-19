<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function Routes()
    {
        Route::group(['prefix' => 'statistic'], function () {
            Route::group(['middleware' => ['can:sta.view']], function () {
                Route::get('/import', [StatisticController::class, 'import'])->name('statistic.import');
                Route::get('/export', [StatisticController::class, 'export'])->name('statistic.export');
                Route::get('/transfer', [StatisticController::class, 'transfer'])->name('statistic.transfer');
                Route::get('/adjust', [StatisticController::class, 'adjust'])->name('statistic.adjust');
            });
        });
    }
    public function import(Request $request)
    {
        $im = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where([['ex_imports.exim_type', 1], ['ex_imports.exim_status', 1], ['ex_imports.deleted_at', null]])
            ->select('ex_imports.*', 'users.name as created_by', DB::raw('date_format(ex_imports.created_at, "%d-%m-%Y %H:%i:%s") as created'))
            ->groupBy('exim_code')
            ->orderByDesc('created_at');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $im->where('ex_imports.warehouse_id', $request->warehouse);
        } else $im->where('ex_imports.warehouse_id', $warehouses[0]->id);
        if (isset($request->quarter)) {
            $im->where(DB::raw('QUARTER(ex_imports.created_at)'), $request->quarter);
        }
        if (isset($request->month)) {
            $im->where(DB::raw('date_format(ex_imports.created_at, "%m")'), $request->month);
        }
        if (isset($request->year)) {
            $im->where(DB::raw('date_format(ex_imports.created_at, "%Y")'), $request->year);
        }
        $im = $im->get();
        return view('admin.components.statistic.import', compact('im', 'warehouses'));
    }
    public function export(Request $request)
    {
        $ex = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where([['ex_imports.exim_type', 0], ['ex_imports.exim_status', 1], ['ex_imports.deleted_at', null]])
            ->select('ex_imports.*', 'users.name as created_by', DB::raw('date_format(ex_imports.created_at, "%d-%m-%Y %H:%i:%s") as created'))
            ->groupBy('exim_code')
            ->orderByDesc('created_at');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $ex->where('ex_imports.warehouse_id', $request->warehouse);
        } else $ex->where('ex_imports.warehouse_id', $warehouses[0]->id);
        if (isset($request->quarter)) {
            $ex->where(DB::raw('QUARTER(ex_imports.created_at)'), $request->quarter);
        }
        if (isset($request->month)) {
            $ex->where(DB::raw('date_format(ex_imports.created_at, "%m")'), $request->month);
        }
        if (isset($request->year)) {
            $ex->where(DB::raw('date_format(ex_imports.created_at, "%Y")'), $request->year);
        }
        $ex = $ex->get();
        return view('admin.components.statistic.export', compact('ex', 'warehouses'));
    }
    public function transfer(Request $request)
    {
        $transfers = DB::table('transfers')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'transfers.warehouse_to')
            ->select('transfers.*', 'users.name', DB::raw('date_format(transfers.created_at, "%d-%m-%Y %H:%i:%s") as created'), 'warehouses.warehouse_name')
            ->where('transfers.transfer_status', 5)
            ->whereNull('transfers.deleted_at')
            ->orderByDesc('created_at');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $transfers->where('transfers.warehouse_from', $request->warehouse);
        } else $transfers->where('transfers.warehouse_from', $warehouses[0]->id);
        if (isset($request->quarter)) {
            $transfers->where(DB::raw('QUARTER(transfers.created_at)'), $request->quarter);
        }
        if (isset($request->month)) {
            $transfers->where(DB::raw('date_format(transfers.created_at, "%m")'), $request->month);
        }
        if (isset($request->year)) {
            $transfers->where(DB::raw('date_format(transfers.created_at, "%Y")'), $request->year);
        }
        $transfers = $transfers->get();
        return view('admin.components.statistic.transfer', compact('transfers', 'warehouses'));
    }
    public function adjust(Request $request)
    {
        $inventories = DB::table('inventories')
            ->join('users', 'users.id', '=', 'inventories.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'inventories.warehouse_id')
            ->select('inventories.*', 'users.name', DB::raw('date_format(inventories.created_at, "%d-%m-%Y %H:%i:%s") as created'), 'warehouses.warehouse_name')
            ->whereNull('inventories.deleted_at')
            ->where('inventories.inventory_status', 1)
            ->orderByDesc('created_at');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $inventories->where('inventories.warehouse_id', $request->warehouse);
        } else $inventories->where('inventories.warehouse_id', $warehouses[0]->id);
        if (isset($request->quarter)) {
            $inventories->where(DB::raw('QUARTER(inventories.created_at)'), $request->quarter);
        }
        if (isset($request->month)) {
            $inventories->where(DB::raw('date_format(inventories.created_at, "%m")'), $request->month);
        }
        if (isset($request->year)) {
            $inventories->where(DB::raw('date_format(inventories.created_at, "%Y")'), $request->year);
        }
        $inventories = $inventories->get();
        return view('admin.components.statistic.adjust', compact('inventories', 'warehouses'));
    }
}
