<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{

    public static function Routes()
    {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouse_managers.warehouse_id', '=', 'warehouses.id')
            ->where('warehouse_managers.user_id', Auth::user()->id)
            ->select('warehouses.*')->get();
        if (isset($request->warehouse)) {
            $warehouse_id = $request->warehouse;
        } else {
            $warehouse_id = $warehouses[0]->id;
        }
        $imports = DB::table('ex_imports')
            ->where([['ex_imports.exim_type', 1], ['ex_imports.deleted_at', null], ['ex_imports.warehouse_id', $warehouse_id], ['ex_imports.exim_status', 0]])
            ->where(DB::raw('date_format(ex_imports.created_at, "%m")'), date('m'))
            ->select('ex_imports.*', DB::raw('date_format(ex_imports.created_at, "%d-%m-%Y %H:%i:%s") as created'))
            ->orderByDesc('created_at')->get();
        $exports = DB::table('ex_imports')
            ->where([['ex_imports.exim_type', 0], ['ex_imports.deleted_at', null], ['ex_imports.warehouse_id', $warehouse_id], ['ex_imports.exim_status', 0]])
            ->where(DB::raw('date_format(ex_imports.created_at, "%m")'), date('m'))
            ->select('ex_imports.*', DB::raw('date_format(ex_imports.created_at, "%d-%m-%Y %H:%i:%s") as created'))
            ->orderByDesc('created_at')->get();
        $sum_im = DB::table('ex_imports')
            ->join('ex_import_details', 'ex_import_details.exim_id', '=', 'ex_imports.id')
            ->where([['ex_imports.exim_type', 1], ['ex_imports.deleted_at', null], ['ex_imports.warehouse_id', $warehouse_id], ['ex_imports.exim_status', 1]])
            ->where(DB::raw('date_format(ex_imports.created_at, "%m")'), date('m'))
            ->sum('ex_import_details.item_quantity');
        $sum_ex = DB::table('ex_imports')
            ->join('ex_import_details', 'ex_import_details.exim_id', '=', 'ex_imports.id')
            ->where([['ex_imports.exim_type', 0], ['ex_imports.deleted_at', null], ['ex_imports.warehouse_id', $warehouse_id], ['ex_imports.exim_status', 1]])
            ->where(DB::raw('date_format(ex_imports.created_at, "%m")'), date('m'))
            ->sum('ex_import_details.item_quantity');
        return view('admin.home.dashboard', compact('warehouses', 'exports', 'imports', 'sum_im', 'sum_ex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
