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
    public static function Routes() {
        // Route::get('shelf', [ShelfController::class, 'index' ])->name('shelf.index');
        Route::get('warehouse/{id}', [ShelfController::class, 'warehouseDetail'])->name('shelf.warehouse-details');
        Route::post('warehouse/{warehouse_id}/add-shelf', [ShelfController::class, 'addShelf'])->name('shelf.add-shelf');
        Route::get('edit-shelf/{id}', [ShelfController::class, 'edit'])->name('shelf.edit');
        Route::put('update-shelf/{id}', [ShelfController::class, 'update'])->name('shelf.update');
        Route::get('delete-shelf/{id}', [ShelfController::class, 'destroy'])->name('shelf.destroy');
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
            'shelf_name' => 'required|unique:shelves,shelf_name,'.$id,
            'shelf_code' => 'required|unique:shelves,shelf_code,'.$id,
            'shelf_position'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = [
            'shelf_code' => $request->shelf_code,
            'shelf_name' => $request->shelf_name,
            'shelf_status' => $request->shelf_status == 'on' ? '1' : '0',
            'shelf_position' => $request->shelf_position,
            'shelf_note' =>$request->shelf_note,
        ];
        $shelf->update($data);

        $warehouse_id = DB::table('warehouse_details')
        ->join('shelves', 'id', '=', 'shelf_id')
        ->where('shelves.id', $id)
        ->select('warehouse_id')
        ->pluck('warehouse_id');

        return redirect()->route('shelf.list',$warehouse_id[0])->with('success', 'cập nhật thành công');
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

    public function warehouseDetail($warehouse_id) {
        $warehouse = Warehouse::find($warehouse_id);
        $shelf = DB::table('warehouse_details')
        ->join('shelves', 'shelves.id', '=', 'warehouse_details.shelf_id')
        ->select('shelves.*')
        ->where('warehouse_details.warehouse_id', $warehouse_id)
        ->get();

        // $items = DB::table('items')
        // ->join('categories', 'categories.id', '=', 'items.category_id')
        // ->join('unit_details', 'unit_details.item_id', '=', 'items.id')
        // ->leftJoin('units', 'units.id', '=', 'unit_details.unit_id')
        // ->leftJoin('warehouses', 'warehouses.id', '=', 'items.warehouse_id')
        // ->rightJoin('shelf_details', 'shelf_details.item_id', '=', 'items.id')
        // ->rightJoin('shelves', 'shelves.id', '=', 'shelf_details.shelf_id')
        // ->select(
        //     'items.*',
        //     'units.id as unit_id',
        //     'units.unit_name',
        //     'categories.category_name',
        //     'shelf_details.item_quantity as item_quantity_of_shelf',
        //     'shelves.shelf_name',
        //     'warehouses.warehouse_name'
        // )
        // ->where('items.warehouse_id', $warehouse_id)
        // ->where('items.item_quantity', '>', '0')
        // ->get();

        return view('admin.components.warehouse.warehousedetail', compact('shelf', 'warehouse_id', 'warehouse'));
    }

    public function addShelf(Request $request, $warehouse_id){
        $validator = Validator::make($request->all(),[
            'shelf_name' => 'required|unique:shelves',
            'shelf_code' => 'required|unique:shelves',
            'shelf_status' => 'required',
            'shelf_position'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $status = 0;

        Shelf::create(array_merge(
            $validator->validate(),
            [
                'shelf_code'=>$request->shelf_code,
                'shelf_name'=>$request->shelf_name,
                'shelf_position'=>$request->shelf_position,
                'shelf_status'=>$request->shelf_status == 'on' ? '1' : '0',
                'shelf_note'=>$request->shelf_note
            ]
        ));

        $shelf = Shelf::orderBy('id', 'desc')->take(1)->get();

        WarehouseDetail::create([
            'warehouse_id'=>$warehouse_id,
            'shelf_id'=>$shelf[0]->id,
        ]);
        return redirect()->back()->with('success', 'Tạo mới giá kệ thành công');
    }

    // public function shelfDetail($shelf_id) {
    //     $items = DB::table('shelf_details')
    //     ->join('shelves','shelves.id', '=','shelf_details.shelf_id')
    //     ->leftJoin('warehouses','warehouses.id', '=','shelves.warehouse_id')
    //     ->join('items','items.id', '=','shelf_details.item_id')
    //     ->rightJoin('units','units.id', '=','items.units_id')
    //     ->rightJoin('categories','categories.id', '=','items.category_id')
    //     ->select('items.*','units.*','shelf.shelf_name','warehouses.warehouse_name')
    //     ->where(['shelf_details.shelf_id','=',$shelf_id])
    //     ->get();
    //     dd($items);
    //     return view('admin.components.shelf.shelf_detail', compact('items'));
    // }


}
