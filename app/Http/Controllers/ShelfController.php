<?php

namespace App\Http\Controllers;

use App\Models\Shelf;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ShelfController extends Controller
{
    public static function Routes()
    {
        // Route::get('shelf', [ShelfController::class, 'index' ])->name('shelf.index');
        Route::get('warehouse/{id}', [ShelfController::class, 'warehouseDetail'])->name('shelf.warehouse-details')->middleware(['can:war.view']);
        Route::post('warehouse/{warehouse_id}/add-shelf', [ShelfController::class, 'addShelf'])->name('shelf.add-shelf')->middleware(['can:she.add']);
        Route::group(['middleware' => ['can:she.edit']], function () {
            Route::get('edit-shelf/{id}', [ShelfController::class, 'edit'])->name('shelf.edit');
            Route::put('update-shelf/{id}', [ShelfController::class, 'update'])->name('shelf.update');
        });
        Route::get('delete-shelf/{id}', [ShelfController::class, 'destroy'])->name('shelf.destroy')->middleware(['can:she.delete']);
        // Route::get('shelf/{id}', [ShelfController::class, 'shelfDetail'])->name('shelf.shelf-detail');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.components.warehouse.warehousedetail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.components.warehouse.addwarehouse');
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
        $shelf = Shelf::find($id);
        return view('admin.components.shelf.editshelf', compact('shelf'));
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
        $shelf = Shelf::find($id);
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required',
            'shelf_code' => 'required',
            'shelf_position' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = [
            'shelf_code' => $request->shelf_code,
            'shelf_name' => $request->shelf_name,
            'shelf_status' => $request->shelf_status == 'on' ? '1' : '0',
            'shelf_position' => $request->shelf_position,
            'shelf_note' => $request->shelf_note,
        ];
        $shelf->update($data);

        $warehouse_id = DB::table('warehouse_details')
            ->join('shelves', 'id', '=', 'shelf_id')
            ->where('shelves.id', $id)
            ->select('warehouse_id')
            ->pluck('warehouse_id');

        // return redirect()->route('shelf.warehouse-details',$warehouse_id[0])->with('success', 'cập nhật thành công');

        return redirect()->back()->with('success', 'cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WarehouseDetail::where('warehouse_id', $id)->delete();
        Shelf::find($id)->delete();
        return redirect()->back()->with('success', 'Thông báo công.');
    }

    public function warehouseDetail($warehouse_id)
    {
        $arr = [];
        $warehouse = Warehouse::find($warehouse_id);
        $shelf = DB::table('warehouse_details')
            ->join('shelves', 'shelves.id', '=', 'warehouse_details.shelf_id')
            ->select('shelves.*')
            ->where('warehouse_details.warehouse_id', $warehouse_id)
            ->get();

        $items = DB::table('item_details')
            ->leftJoin('items', 'items.id', '=', 'item_details.item_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->leftJoin('units', 'units.id', '=', 'items.item_unit')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->select(
                'items.*',
                'warehouse_name',
                'shelf_name',
                'item_details.supplier_id',
                'cell_id',
                'floor_id',
                'category_name',
                'unit_name',
                'item_details.item_quantity as item_detail_quantity',
                'item_details.id as itemdetail_id',
                'items.item_quantity as item_valid'
            )
            ->orderByDesc('items.item_name')
            ->where('item_details.warehouse_id', $warehouse_id)
            ->where('item_details.item_quantity', '>', '0')
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
            $val->item_valid = [
                $val->item_detail_quantity - $exim_invalid[0]->quantity - $trans_invalid[0]->quantity,
                $exim_invalid[0]->quantity +  $trans_invalid[0]->quantity
            ];
        }
        return view('admin.components.warehouse.warehousedetail', compact('shelf', 'warehouse_id', 'warehouse', 'items'));
    }

    public function addShelf(Request $request, $warehouse_id)
    {
        $validator = Validator::make($request->all(), [
            'shelf_name' => 'required|unique:shelves',
            'shelf_code' => 'required|unique:shelves',
            'shelf_status' => 'required',
            'shelf_position' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $status = 0;

        Shelf::create(array_merge(
            $validator->validate(),
            [
                'shelf_code' => $request->shelf_code,
                'shelf_name' => $request->shelf_name,
                'shelf_position' => $request->shelf_position,
                'shelf_status' => $request->shelf_status == 'on' ? '1' : '0',
                'shelf_note' => $request->shelf_note
            ]
        ));

        $shelf = Shelf::orderBy('id', 'desc')->take(1)->get();

        WarehouseDetail::create([
            'warehouse_id' => $warehouse_id,
            'shelf_id' => $shelf[0]->id,
        ]);
        return redirect()->back()->with('success', 'Tạo mới giá kệ thành công');
    }

    // public function shelfDetail($shelf_id) {

    //     dd($items);
    //     return view('admin.components.shelf.shelf_detail', compact('items'));
    // }


}
