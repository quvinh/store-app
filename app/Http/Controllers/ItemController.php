<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public static function Routes()
    {
        Route::group(['prefix' => 'item'], function () {
            Route::get('', [ItemController::class, 'index'])->name('item.index');
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
        $items = DB::table('items')
            ->join('unit_details', 'item_id', '=', 'items.id')
            ->join('units', 'units.id', '=', 'unit_details.unit_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            // ->where('ex_imports.exim_status', 0)
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')->get();
        $itemTrash = $items = DB::table('items')
            ->join('unit_details', 'item_id', '=', 'items.id')
            ->join('units', 'units.id', '=', 'unit_details.unit_id')
            ->join('categories', 'categories.id', '=', 'items.category_id')
            ->whereNotNull('items.deleted_at')
            ->select('items.*', 'units.unit_name as unit', 'categories.category_name as category')->get();
        return view('admin.components.item.manitem', compact('items', 'itemTrash'));
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
