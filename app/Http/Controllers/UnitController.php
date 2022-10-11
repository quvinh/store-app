<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    public static function Routes() {
        Route::get('unit', [UnitController::class, 'index' ])->name('unit.index');
        Route::post('unit', [UnitController::class, 'store'])->name('unit.store');
        Route::get('unit/{id}', [UnitController::class,'edit'])->name('unit.edit');
        Route::put('unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
        Route::get('unit/delete/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit = Unit::all();
        return view('admin.components.unit.manunit', compact('unit'));
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
            'unit_name' => 'required|unique:units',
            'unit_amount' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = [
            'unit_name' => $request->unit_name,
            'unit_amount' => $request->unit_amount,
        ];
        Unit::create(array_merge(
            $validator->validate(),
            $data
        ));

        return redirect()->route('unit.index')->with('success','Tạo mới đơn vị tính thành công');
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
        $unit = Unit::find($id);
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required|unique:units,unit_name,'.$id,
            'unit_amount' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data = [
            'unit_name' => $request->unit_name,
            'unit_amount' => $request->unit_amount,
        ];
        $unit->update($data);

        return redirect()->route('unit.index')->with('success','Sửa đơn vị tính thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unitdetails = DB::table('unit_details')->where('unit_id', $id)->get();
        if($unitdetails != '' || $unitdetails != null)
        {
            Unit::find($id)->delete();
            return redirect()->back()->with('success','Xóa thành công');
        }
        else{
            return redirect()->back()->with('error','Xóa không thành công');
        }
    }
}
