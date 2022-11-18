<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use App\Models\UnitDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public static function Routes()
    {
        Route::group(['prefix' => 'item'], function () {
            Route::get('', [ItemController::class, 'index'])->name('item.index')->middleware(['can:ite.view']);
            Route::group(['middleware' => ['can:ite.add']], function () {
                Route::get('/create', [ItemController::class, 'create'])->name('item.create');
                Route::post('/store', [ItemController::class, 'store'])->name('item.store');
            });
            Route::group(['middleware' => ['can:ite.edit']], function () {
                Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
                Route::put('/update/{id}', [ItemController::class, 'update'])->name('item.update');
            });
            Route::group(['middleware' => ['can:ite.delete']], function () {
                Route::get('/delete/{id}', [ItemController::class, 'delete'])->name('item.delete');
                Route::get('/restore/{id}', [ItemController::class, 'restore'])->name('item.restore');
                Route::get('/destroy/{id}', [ItemController::class, 'destroy'])->name('item.destroy');
            });
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('items')
            ->join('unit_details', 'items.id', '=', 'unit_details.item_id')
            ->join('units', 'units.id', '=', 'unit_details.unit_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')
            ->groupBy('items.id')
            ->whereNull('items.deleted_at')->get();
        $dataTrash = $items = DB::table('items')
            ->join('unit_details', 'items.id', '=', 'unit_details.item_id')
            ->join('units', 'units.id', '=', 'unit_details.unit_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->whereNotNull('items.deleted_at')
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')
            ->get();
        return view('admin.components.item.manitem', compact('data', 'dataTrash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        $categories = Category::all();
        return view('admin.components.item.additem', compact('units', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|unique:items',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $item = Item::create([
            'item_name' => $request->item_name,
            'category_id' => $request->category,
            'item_status' => $request->item_status == 'on' ? '1' : '0',
            'item_note' => $request->item_note,
        ]);
        foreach($request->unit_name as $key => $val){
            $unit = Unit::create([
                'unit_name' => $val,
                'unit_amount' => $request->unit_amount[$key],
            ]);
            UnitDetail::create([
                'unit_id' => $unit->id,
                'item_id' => $item->id,
            ]);
        }

        return redirect()->route('item.index')->with('success', 'Tạo mới vật tư thành công');
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
        $units = Unit::join('unit_details', 'unit_details.unit_id' , '=', 'units.id')
        ->where('unit_details.item_id', $id)->get();
        // dd($units);
        $categories = Category::all();
        $item = Item::find($id);
        return view('admin.components.item.edititem', compact('units', 'categories', 'item'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Item::find($id)->update([
            'item_name' => $request->item_name,
            'category_id' => $request->category,
            'item_status' => $request->item_status == 'on' ? '1' : '0',
            'item_note' => $request->item_note,
        ]);
        foreach($request->unit_name as $key => $val){
            $unit = Unit::find($request->unit_id[$key])->update([
                'unit_name' => $val,
                'unit_amount' => $request->unit_amount[$key],
            ]);
            UnitDetail::where('item_id', $id)->delete();
            UnitDetail::create([
                'unit_id' => $request->unit_id[$key],
                'item_id' => Item::find($id)->id,
            ]);
        }
        return redirect()->route('item.index')->with('success', 'Cập nhật vật tư thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Item::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa nhà cung cấp thành công.');
    }

    public function restore($id)
    {
        Item::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục nhà cung cấp thành công.');
    }

    public function destroy($id)
    {
        Item::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn nhà cung cấp thành công.');
    }

    // public function detailItems($id) {
    //     $items = DB::table('items')
    //     ->join('item_details', 'item_details.item_id', '=', 'items.id')
    //     ->join('categories', 'categories.id', '=', 'item_details.category_id')
    //     ->join('unit_details', 'unit_details.item_id', '=', 'item_details.item_id')
    //     ->join('unit', 'unit.id', '=', 'unit_details.unit_id')
    //     ->join('suppliers', 'suppliers.id', '=','item_details.supplier_id')
    //     ->select('items.*', 'supplier_name', 'category_name', 'unit_name')
    //     ->where('items.id', $id)
    //     ->get();

    //     return $items;
    // }
}
