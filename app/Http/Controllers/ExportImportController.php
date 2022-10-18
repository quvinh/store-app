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
        Route::get('example', [ExportImportController::class, 'example'])->name('example');
        Route::get('get-shelf', [ExportImportController::class, 'getShelf'])->name('get-shelf');

        Route::get('ex_import', [ExportImportController::class, 'index'])->name('ex_import.index');
        Route::group(['prefix' => 'import'], function () {
            Route::get('', [ExportImportController::class, 'import'])->name('import.index');
            Route::post('/store', [ExportImportController::class, 'im_store'])->name('import.store');
            Route::get('/edit/{id}', [ExportImportController::class, 'im_edit'])->name('import.edit');
            Route::put('/update/{id}', [ExportImportController::class, 'im_update'])->name('import.update');
        });

        Route::get('export', [ExportImportController::class, 'export'])->name('ex_import.export');
        Route::post('exstore', [ExportImportController::class, 'exstore'])->name('ex_import.exstore');
        Route::get('export/export-detail/{id}', [ExportImportController::class, 'exportDetail'])->name('export.export-detail');

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
            ->where('ex_imports.exim_type', 0)
            ->select('ex_imports.*', 'items.item_name as item')->get();
        foreach ($ex_items as $val) {
            $val->item = DB::table('items')
                ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
                ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
                ->where('ex_imports.exim_type', 0)
                ->where('ex_imports.exim_code', $val->exim_code)
                ->select('items.item_name as item')
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
        $ex_items = DB::table('ex_imports')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'ex_imports.warehouse_id')
            ->where('ex_imports.exim_type', 0)
            ->select(
                'ex_imports.*',
                'users.name as user_name',
                'warehouse_name'
            )
            // ->groupBy('ex_imports.exim_code')
            ->orderByDesc('created_at')->get();
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

    public function im_edit($id){
        $im_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->where('ex_imports.id', $id)
            ->select('ex_import_details.*', 'items.item_name as item', 'ex_imports.exim_code', 'ex_imports.exim_status', 'ex_imports.warehouse_id')
            ->get();
        return view('admin.components.ex_import.editimport', compact('im_items'));
    }
    public function im_update(Request $request){

    }
    public function export()
    {
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $items = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->select(
                'items.*',
                'item_details.item_quantity as item_detail_quantity',
                'warehouse_id',
                'supplier_id',
                'shelf_id',
                'floor_id',
                'cell_id',
                'item_details.id as item_detail_id',
                'shelf_name',
                'warehouse_name',
                'category_name'
            )

            ->whereNull('items.deleted_at')->get();
        // dd($items);
        // DD($suppliers);
        $shelves = DB::table('shelves')->whereNull('deleted_at')->get();
        foreach ($items as $item) {
            $item->value = $item->item_name;
            $item->data = $item->id;
        }
        return view('admin.components.ex_import.export', compact('categories', 'suppliers', 'units', 'warehouses', 'items', 'shelves'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exstore($id)
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
    public function delete($id)
    {
        ExImport::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa nhà cung cấp thành công.');
    }

    public function restore($id)
    {
        ExImport::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục nhà cung cấp thành công.');
    }

    public function destroy($id)
    {
        ExImport::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn nhà cung cấp thành công.');
    }

    public function getWarehouse()
    {
        $warehouses = DB::table('warehouses')->get();
        return $warehouses;
    }

    // public function exportDetail($id)
    // {
    //     $export = DB::table(ex_import_details)

    //     // $export = DB::table('ex_imports')
    //     //     ->join(DB::raw('SELECT ex_import_details.id,exim_id, itemdetail_id , item_price,item_total, item_vat, supplier_id, shelf_to,floor_to, cell_to, SUM(ex_import_details.item_quantity) as ex_item_quantity FROM (ex_import_details JOIN item_details ON item_details.id = ex_import_details.itemdetail_id) GROUP BY item_id, exim_id'), 'ex_import_details.exim_id', '=', 'ex_imports.id')
    //         // ->join('users', 'users.id', '=', 'ex_imports.user_id')
    //         // ->join('warehouses', 'warehouses.id', '=', 'ex_imports.warehouse_id')
    //         // ->whereNull('ex_imports.deleted_at')
    //         // ->where('ex_imports.id', $id)
    //         // ->select('ex_imports.*', 'users.name')
    //         // ->orderByDesc('created_at')
    //         // ->get();
    //     dd($export);
    //     return view('admin.components.ex_import.detail_export', compact('export'));
    // }

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
