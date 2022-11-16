<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public static function Routes()
    {
        Route::get('category', [CategoryController::class, 'index'])->name('category.index')->middleware(['can:cat.view']);
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store')->middleware(['can:cat.add']);
        Route::group(['middleware' => ['can:cat.edit']], function () {
            Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        });
        Route::get('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware(['can:cat.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.components.category.mancategory', compact('categories'));
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
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:categories',
            'category_code' => 'required|unique:categories',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Category::create([
            'category_name' => $request->category_name,
            'category_code' => $request->category_code,
            'category_status' => $request->category_status == 'on' ? '1' : '0',
            'category_note' => $request->category_note,
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Tạo mới loại vật tư "' . $request->category_name . '"');
        return redirect()->back()->with('success', 'Tạo mới loại vật tư thành công');
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
        $category = Category::find($id);
        return view('admin.components.category.editcategory', compact('category'));
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
            'category_name' => 'required',
            'category_code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Category::find($id)->update([
            'category_name' => $request->category_name,
            'category_code' => $request->category_code,
            'category_status' => $request->category_status == 'on' ? '1' : '0',
            'category_note' => $request->category_note,
        ]);
        return redirect()->route('category.index')->with('success', 'Cập nhật loại vật tư thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->route('category.index')->with('success', 'Xóa loại vật tư thành công');
    }
}
