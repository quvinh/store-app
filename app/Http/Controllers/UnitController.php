<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\UnitDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    public static function Routes()
    {
        Route::get('unit', [UnitController::class, 'index'])->name('unit.index')->middleware(['can:uni.view']);
        Route::post('unit', [UnitController::class, 'store'])->name('unit.store')->middleware(['can:uni.add']);
        Route::group(['middleware' => ['can:uni.edit']], function () {
            Route::get('unit/show/{name}', [UnitController::class, 'show'])->name('unit.show');
            Route::get('unit/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
            Route::put('unit/update/{id}', [UnitController::class, 'update'])->name('unit.update');
        });
        Route::group(['middleware' => ['can:uni.delete']], function () {
            Route::get('unit/destroy/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
            Route::get('unit/delete/{id}', [UnitController::class, 'delete'])->name('unit.delete');
            Route::get('unit/restore/{id}', [UnitController::class, 'restore'])->name('unit.restore');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::where('deleted_at', null)->groupBy('unit_name')->get();
        $unitTrashed = Unit::onlyTrashed()->get();
        $items = Item::all();
        return view('admin.components.unit.manunit', compact('units', 'unitTrashed', 'items'));
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
        $unit = Unit::create([
            'unit_name' => $request->unit_name,
            'unit_amount' => $request->unit_amount ? $request->unit_amount : '1',
        ]);
        UnitDetail::create([
            'unit_id' => $unit->id,
            'item_id' => $request->item,
        ]);
        return redirect()->route('unit.index')->with('success', 'Th??m m???i ????n v??? t??nh th??nh c??ng');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $units = DB::table('items')->join('unit_details', 'unit_details.item_id', '=', 'items.id')
        ->join('units', 'units.id', '=', 'unit_details.unit_id')
        ->where('unit_name','like', $name)
        ->select('units.*', 'items.item_name')
        ->get();
        return view('admin.components.unit.showunit', compact('units'));
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
        return redirect()->route('unit.index')->with('success', 'C???p nh???t ????n v??? t??nh th??nh c??ng');
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
        return redirect()->back()->with('success', 'X??a ????n v??? t??nh th??nh c??ng.');
    }

    public function restore($id)
    {
        Unit::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Kh??i ph???c ????n v??? t??nh th??nh c??ng.');
    }

    public function destroy($id)
    {
        Unit::find($id)->forceDelete();
        return redirect()->back()->with('success', 'X??a ????n v??? t??nh th??nh c??ng.');
    }
}
