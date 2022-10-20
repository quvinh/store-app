<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public static function Routes()
    {
        Route::get('/detail_item', [ItemController::class, 'detail'])->name('detail_item.index');
        Route::group(['prefix' => 'item'], function () {
            Route::get('', [ItemController::class, 'index'])->name('item.index');
            Route::get('/create', [ItemController::class, 'create'])->name('item.create');
            Route::post('/store', [ItemController::class, 'store'])->name('item.store');
            Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
            Route::put('/update/{id}', [ItemController::class, 'update'])->name('item.update');
            Route::get('/delete/{id}', [ItemController::class, 'delete'])->name('item.delete');
            Route::get('/restore/{id}', [ItemController::class, 'restore'])->name('item.restore');
            Route::get('/destroy/{id}', [ItemController::class, 'destroy'])->name('item.destroy');
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
            ->join('units', 'units.id', '=', 'items.item_unit')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')
            ->whereNull('items.deleted_at')->get();
        $dataTrash = $items = DB::table('items')
            ->join('units', 'units.id', '=', 'items.item_unit')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->whereNotNull('items.deleted_at')
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')
            ->get();
        return view('admin.components.item.manitem', compact('data', 'dataTrash'));
    }
    public function detail() {
        return view('admin.components.item.detail_item');
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
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|unique:items',
            'item_code' => 'required|unique:items',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Item::create([
            'item_name' => $request->item_name,
            'item_code' => $request->item_code,
            'item_unit' => $request->item_unit,
            'category_id' => $request->category,
            'item_status' => $request->item_status == 'on' ? '1' : '0',
            'item_note' => $request->item_note,
        ]);
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
        $units = Unit::all();
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
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'item_code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Item::create([
            'item_name' => $request->item_name,
            'item_code' => $request->item_code,
            'item_unit' => $request->item_unit,
            'category_id' => $request->category,
            'item_max' => $request->item_max,
            'item_min' => $request->item_min,
            'item_status' => $request->item_status == 'on' ? '1' : '0',
            'item_note' => $request->item_note,
        ]);
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
}
