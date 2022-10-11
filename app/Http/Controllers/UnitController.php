<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    public static function Routes()
    {
        Route::get('unit', [UnitController::class, 'index'])->name('unit.index');
        Route::post('unit', [UnitController::class, 'store'])->name('unit.store');
        Route::get('unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
        Route::put('unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
        Route::get('unit/destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
        Route::get('unit/delete/{id}', [UnitController::class, 'delete'])->name('unit.delete');
        Route::get('unit/restore/{id}', [UnitController::class, 'restore'])->name('unit.restore');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::where('deleted_at', null)->get();
        $unitTrashed = Unit::onlyTrashed()->get();
        return view('admin.components.unit.manunit', compact('units', 'unitTrashed'));
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
            'unit_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Unit::create([
            'unit_name' => $request->unit_name,
            'unit_amount' => $request->unit_amount ? $request->unit_amount : '1',
        ]);
        return redirect()->route('unit.index')->with('success', 'Thêm mới đơn vị tính thành công');
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
        $unit = Unit::find($id);
        return view('admin.components.unit.editunit', compact('unit'));
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
            'unit_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Unit::find($id)->update([
            'unit_name' => $request->unit_name,
            'unit_amount' => $request->unit_amount,
        ]);
        return redirect()->route('unit.index')->with('success', 'Cập nhật đơn vị tính thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Unit::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa đơn vị tính thành công.');
    }

    public function restore($id)
    {
        Unit::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục đơn vị tính thành công.');
    }

    public function destroy($id)
    {
        Unit::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa đơn vị tính thành công.');
    }
}
