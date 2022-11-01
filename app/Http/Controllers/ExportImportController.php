<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExImport;
use App\Models\ExImportDetail;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ExportImportController extends Controller
{

    public static function Routes()
    {

        Route::get('ex_import', [ExportImportController::class, 'index'])->name('ex_import.index');
        Route::group(['prefix' => 'import'], function () {
            Route::get('', [ExportImportController::class, 'import'])->name('import.index');
            Route::post('/store', [ExportImportController::class, 'im_store'])->name('import.store');
            Route::get('/edit/{id}', [ExportImportController::class, 'im_edit'])->name('import.edit');
            Route::put('/update/{id}', [ExportImportController::class, 'im_update'])->name('import.update');
            Route::get('/confirm/{id}', [ExportImportController::class, 'im_confirm'])->name('import.confirm');
            Route::put('/update-status/{id}', [ExportImportController::class, 'im_update_status'])->name('import.update-status');
        });

        Route::group(['prefix' => 'export'], function () {
            Route::get('/', [ExportImportController::class, 'export'])->name('export.index');
            Route::post('/exstore', [ExportImportController::class, 'exportStore'])->name('export.store');
            Route::get('/export-detail/{id}', [ExportImportController::class, 'exportDetail'])->name('export.edit');
            Route::put('/update-export/{exim_id}/{id}', [ExportImportController::class, 'exportUpdate'])->name('export.update');
        });
        Route::group(['prefix' => 'ex_import'], function () {
            Route::get('/delete/{id}', [ExportImportController::class, 'delete'])->name('ex_import.delete');
            Route::get('/restore/{id}', [ExportImportController::class, 'restore'])->name('ex_import.restore');
            Route::get('/destroy/{id}', [ExportImportController::class, 'destroy'])->name('ex_import.destroy');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $im_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.exim_type', 1)
            ->select('ex_imports.*', 'items.item_name as item', 'users.name as created_by')
            ->groupBy('exim_code')
            ->orderByDesc('created_at')
            ->orderBy('exim_status', 'asc')
            ->get();
        foreach ($im_items as $val) {
            $val->item = DB::table('items')
                ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
                ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
                ->where('ex_imports.exim_type', 1)
                ->where('ex_imports.exim_code', $val->exim_code)
                ->select('items.item_name as item')
                ->get();
        }
        $ex_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.exim_type', 0)
            ->groupBy('ex_imports.exim_code')
            ->select('ex_imports.*', 'items.item_name as item', 'users.name as created_by')
            ->orderByDesc('created_at')
            ->get();
        foreach ($ex_items as $val) {
            $val->item = DB::table('items')
                ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
                ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
                ->where('ex_imports.exim_type', 0)
                ->where('ex_imports.exim_code', $val->exim_code)
                ->select('items.item_name as item')
                ->groupBy('items.item_name')
                ->get();
        }
        // return view('admin.components.ex_import.manex_import', compact('im_items', 'ex_items'));
        // $im_items = DB::table('items')
        //     ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
        //     ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
        //     ->where('ex_imports.exim_type', 1)
        //     ->select('ex_imports.*')->get();
        // $ex_items = DB::table('ex_imports')
        //     ->join('users', 'users.id', '=', 'ex_imports.user_id')
        //     ->join('ex_import_details', 'ex_import_details.exim_id', '=', 'ex_imports.id')
        //     ->join('item_details', 'item_details.id', '=', 'ex_import_details.itemdetail_id')
        //     ->join('items', 'items.id', '=', 'item_details.item_id')
        //     ->join('categories', 'categories.id', '=', 'items.category_id')
        //     ->join('unit_details', 'unit_details.item_id', '=', 'items.id')
        //     ->join('units', 'units.id', '=','unit_details.unit_id')
        //     ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
        //     ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
        //     ->where('ex_imports.exim_type', 0)
        //     ->select('ex_imports.*', 'items.item_name')->orderByDesc('created_at')->get();
        // $ex_items = DB::table('ex_imports')
        //     ->join('users', 'users.id', '=', 'ex_imports.created_by')
        //     ->join('warehouses', 'warehouses.id', '=', 'ex_imports.warehouse_id')
        //     ->where('ex_imports.exim_type', 0)
        //     ->select(
        //         'ex_imports.*',
        //         'users.name as user_name',
        //         'warehouse_name'
        //     )
        //     // ->groupBy('ex_imports.exim_code')
        //     ->orderByDesc('created_at')->get();
        return view('admin.components.ex_import.manex_import', compact('im_items', 'ex_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $shelves = DB::table('shelves')->whereNull('deleted_at')->get();
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $items = DB::table('items')->whereNull('deleted_at')->get();
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouse_managers.warehouse_id', '=', 'warehouses.id')
            ->where('warehouse_managers.user_id', Auth::user()->id)
            ->select('warehouses.*')->get();
        foreach ($items as $item) {
            $item->value = $item->item_name;
            $item->data = $item->id;
        }
        return view('admin.components.ex_import.import', compact('shelves', 'categories', 'suppliers', 'units', 'items', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function im_store(Request $request)
    {
        $count = count($request->id);
        $date = date('dmY');
        $stt = DB::table('ex_imports')->where([
            'warehouse_id' => $request->warehouse[0],
            'exim_type' => 1,
        ])->whereDate('created_at', '=', Carbon::now()->toDateString())->count();
        $import = ExImport::create([
            'warehouse_id' => $request->warehouse[0],
            'exim_code' => 'IM_' . $date . '_' . ($stt + 1),
            'exim_type' => 1,
            'created_by' => Auth::user()->id,
            'exim_status' => 0,
            'invoice_id' => 0,
        ]);
        for ($i = 0; $i < $count; $i++) {
            ExImportDetail::create([
                'exim_id' => $import->id,
                'item_id' => $request->id[$i],
                'supplier_id' => $request->supplier[$i],
                'warehouse_id' => $request->warehouse[$i],
                'item_quantity' => $request->quantity[$i],
                'item_price' => $request->price[$i],
                'item_total' => 0,
                'itemdetail_id' => 0,
                'item_vat' => 0
            ]);
        }
        return redirect()->route('ex_import.index')->with(['success', 'Tạo phiếu nhập thành công.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function im_edit($id)
    {
        $im_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('suppliers', 'suppliers.id', '=', 'ex_import_details.supplier_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.id', $id)
            ->select(
                'ex_import_details.*',
                'items.item_name as item',
                'ex_imports.exim_code',
                'ex_imports.exim_status',
                'ex_imports.warehouse_id',
                'ex_imports.id as exim_id',
                'suppliers.supplier_name',
                'users.name',
            )
            ->get();
        return view('admin.components.ex_import.editimport', compact('im_items'));
    }

    public function im_update(Request $request)
    {
        //
    }
    public function im_confirm($id)
    {
        $im_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('suppliers', 'suppliers.id', '=', 'ex_import_details.supplier_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.id', $id)
            ->select(
                'ex_import_details.*',
                'items.item_name as item',
                'ex_imports.exim_code',
                'ex_imports.exim_status',
                'ex_imports.warehouse_id',
                'suppliers.supplier_name',
                'users.name',
            )
            ->get();
        $shelves = DB::table('shelves')
            ->join('warehouse_details', 'warehouse_details.shelf_id', '=', 'shelves.id')
            ->select('shelves.*')
            ->where('warehouse_details.warehouse_id', $im_items->first()->warehouse_id)->get();
        return view('admin.components.ex_import.confirmimport', compact('im_items', 'shelves'));
    }

    public function im_update_status(Request $request)
    {
        $exim_id = ExImportDetail::find($request->id[0])->exim_id;
        $warehouse_id = ExImport::find($exim_id)->warehouse_id;
        foreach ($request->id as $key => $id) {
            ExImportDetail::find($id)->update([
                'exim_detail_status' => 1,
                'shelf_to' => $request->shelf[$key],
                'floor_to' => $request->floor[$key],
                'cell_to' => $request->cell[$key],
            ]);
            $import = ExImportDetail::find($id);
            $item = ItemDetail::where([
                ['item_id', $import->item_id], ['warehouse_id', $warehouse_id],
                ['supplier_id', $import->supplier_id], ['shelf_id', $import->shelf_to],
                ['floor_id', $import->floor_to], ['cell_id', $import->cell_to],
            ]);

            if ($item->count() > 0) {
                $quantity = $item->first()->item_quantity;
                $item->update(['item_quantity' => $quantity + $import->item_quantity]);
            } else {
                $item_detail = ItemDetail::create([
                    'item_id' => $import->item_id,
                    'warehouse_id' => $warehouse_id,
                    'supplier_id' => $import->supplier_id,
                    'shelf_id' => $import->shelf_to,
                    'floor_id' => $import->floor_to,
                    'cell_id' => $import->cell_to,
                    'item_quantity' => $import->item_quantity,
                ]);
                ExImportDetail::find($id)->update(['itemdetail_id' => $item_detail->id]);
            }
        }
        ExImport::find($exim_id)->update(['exim_status' => 1]);
        return redirect()->route('ex_import.index')->with(['success', 'Duyệt phiếu nhập thành công.']);
    }


    public function export(Request $request)
    {

        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse_id)) {
            $warehouse_id = $request->warehouse_id;
        } else $warehouse_id = $warehouses[0]->id;
        $items = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'item_details.supplier_id')
            ->select(
                'items.*','item_details.id as itemdetail_id',
                'item_details.item_quantity as item_detail_quantity',
                'warehouse_id','supplier_id','shelf_id','floor_id','cell_id',
                'shelf_name','warehouse_name','category_name','supplier_name'
            )

            ->whereNull('items.deleted_at')
            ->where('item_details.item_quantity','>',0)
            ->where('item_details.warehouse_id', $warehouse_id)
            ->get();
        foreach ($items as $val) {
            $exim_invalid = DB::table('ex_import_details')
                ->join('item_details', 'item_details.id', '=', 'ex_import_details.itemdetail_id')
                ->select(
                    DB::raw('SUM(ex_import_details.item_quantity) as quantity'),
                )
                ->where('ex_import_details.exim_detail_status', '0')
                ->where('item_details.id', $val->itemdetail_id)
                ->get();
            $trans_invalid = DB::table('transfer_details')
                ->join('transfers', 'transfers.id', '=', 'transfer_details.transfer_id')
                ->select(
                    DB::raw('SUM(transfer_details.item_quantity) as quantity'),
                )
                ->where('transfers.transfer_status', '0')
                ->where('transfer_details.itemdetail_id', $val->itemdetail_id)
                ->get();
            if ($exim_invalid[0]->quantity == null) {
                $exim_invalid[0]->quantity = 0;
            }
            if ($trans_invalid[0]->quantity == null) {
                $trans_invalid[0]->quantity = 0;
            }
            $val->item_quantity = [
                $val->item_detail_quantity - $exim_invalid[0]->quantity - $trans_invalid[0]->quantity,
                $exim_invalid[0]->quantity +  $trans_invalid[0]->quantity
            ];
        }
        // dd($items);
        return view('admin.components.ex_import.export', compact('warehouses', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportStore(Request $request)
    {
        $count = count($request->itemdetail_id);
        $date = date('dmY');
        $stt = DB::table('ex_imports')->where('exim_type', '0')->whereDate('created_at', '=', Carbon::now()->toDateString())->count();
        $export = ExImport::create([
            'warehouse_id' => $request->warehouse_id,
            'exim_code' => 'EX_' . $date . '_' . ($stt + 1),
            'exim_type' => 0,
            'created_by' => Auth::user()->id,
            'exim_status' => 0,
            'invoice_id' => 0,
        ]);
        for ($i = 0; $i < $count; $i++) {
            if ($request->item_valid[$i] < $request->item_quantity[$i]) {
                $last3 = DB::table('ex_imports')->orderBy('id', 'DESC')->first();
                ExImport::find($last3->id)->forceDelete();
                return redirect()->back()->withErrors('Tạo phiếu thất bại, Số lượng nhập không thể lớn hơn số lượng khả dụng');
            }
            $items = DB::table('item_details')
                ->where('item_details.id', $request->itemdetail_id[$i])
                ->select('item_details.*')
                ->get();

            ExImportDetail::create([
                'exim_id' => $export->id,
                'item_id' => $items[0]->item_id,
                'supplier_id' => $items[0]->supplier_id,
                'warehouse_id' => $items[0]->warehouse_id,
                'item_quantity' => $request->item_quantity[$i],
                'item_price' => $request->export_price[$i],
                'item_total' => 0,
                'itemdetail_id' => $items[0]->id,
                'item_vat' => 0
            ]);
        }

        return redirect()->route('ex_import.index')->with(['success', 'Tạo phiếu nhập thành công.']);
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
    public function delete($id)
    {
        ExImport::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }

    public function restore($id)
    {
        ExImport::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục thành công.');
    }

    public function destroy($id)
    {
        ExImport::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn thành công.');
    }

    public function getWarehouse()
    {
        $warehouses = DB::table('warehouses')->get();
        return $warehouses;
    }

    public function exportDetail($id)
    {
        $export = DB::table('ex_imports')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.id', $id)
            ->select('ex_imports.*', 'name')
            ->get();
        $export_details = DB::table('ex_import_details')
            ->join('item_details', 'item_details.id', '=', 'ex_import_details.itemdetail_id')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('suppliers', 'suppliers.id', '=', 'item_details.supplier_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->join('units', 'units.id', '=', 'items.item_unit')
            ->select(
                'ex_import_details.id as ex_import_details_id','exim_id','itemdetail_id',
                'item_price','item_total','item_vat','exim_detail_status',
                'ex_import_details.supplier_id','shelf_name','warehouse_name',
                'floor_id','cell_id','ex_import_details.item_quantity as ex_item_quantity',
                // DB::raw('SUM(ex_import_details.item_quantity) as ex_item_quantity'),
                'items.*','supplier_name','unit_name','category_name',
            )
            ->where('exim_id', $id)
            ->get();
        return view('admin.components.ex_import.editexport', compact('export', 'export_details'));
    }

    public function exportUpdate($exim_id, $id)
    {
        $ex_item_details = DB::table('ex_import_details')
            ->where('itemdetail_id', $id)
            ->where('exim_id', $exim_id)
            ->get();
        // $ex_item_details = ExImportDetail::where('itemdetail_id', $id)->where('exim_id', $id);

        $ex_items = ExImport::find($exim_id);

        $item_details = ItemDetail::find($id);
        $count = DB::table('ex_import_details')->where('exim_id', $exim_id)->where('exim_detail_status', 0)->count();

        if ($count > 1) {
            DB::table('ex_import_details')
                ->where('itemdetail_id', $id)
                ->where('exim_id', $exim_id)
                ->update([
                    'exim_detail_status' => '1'
                ]);
            $item_details->update([
                'item_quantity' => $item_details->item_quantity - $ex_item_details[0]->item_quantity
            ]);
        } else {
            DB::table('ex_import_details')
                ->where('itemdetail_id', $id)
                ->where('exim_id', $exim_id)
                ->update([
                    'exim_detail_status' => '1'
                ]);
            $item_details->update([
                'item_quantity' => $item_details->item_quantity - $ex_item_details[0]->item_quantity
            ]);
            $ex_items->update([
                'exim_status' => '1'
            ]);
        }

        return redirect()->back()->with('success', 'Duyệt thành công');
    }

    public function example()
    {
        $warehouses = $this->getWarehouse();
        return view('admin.components.ex_import.example', compact('warehouses'));
    }

    public function getShelf(Request $request)
    {
        $shelf = DB::table('shelves')
            ->leftJoin('warehouse_details', 'warehouse_details.shelf_id', '=', 'shelves.id')
            ->leftJoin('warehouses', 'warehouses.id', '=', 'warehouse_details.warehouse_id')
            ->where('warehouse_details.warehouse_id', $request->warehouse_id)
            ->select('shelves.*')
            ->get();
        // dd($shelf);
        if (count($shelf) > 0) {
            return response()->json($shelf);
        }
    }
}
