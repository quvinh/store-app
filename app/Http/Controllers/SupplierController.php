<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public static function Routes()
    {
        Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index')->middleware(['can:sup.view']);
        Route::group(['middleware' => ['can:sup.add']], function () {
            Route::get('supplier/add', [SupplierController::class, 'create'])->name('supplier.add');
            Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
        });
        Route::group(['middleware' => ['can:sup.edit']], function () {
            Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
            Route::put('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        });
        Route::group(['middleware' => ['can:sup.delete']], function () {
            Route::get('supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
            Route::get('supplier/restore/{id}', [SupplierController::class, 'restore'])->name('supplier.restore');
            Route::get('supplier/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $supplierTrash = Supplier::onlyTrashed()->get();
        return view('admin.components.supplier.mansupplier', compact('suppliers', 'supplierTrash'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.components.supplier.addsupplier');
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
            'supplier_name' => 'required|unique:suppliers',
            'supplier_code' => 'required|unique:suppliers',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'supplier_code' => $request->supplier_code,
            'supplier_status' => $request->supplier_status == 'on' ? '1' : '0',
            'supplier_codetax' => $request->supplier_codetax ? $request->supplier_codetax : 0,
            'supplier_phone' => $request->supplier_phone ? $request->supplier_phone : 0,
            'supplier_email' => $request->supplier_email ? $request->supplier_email : 0,
            'supplier_type' => $request->supplier_type ? $request->supplier_type : 0,
            'supplier_citizenid' => $request->supplier_citizenid ? $request->supplier_citizenid : 0,
            'bank_id' => $request->bank_id ? $request->bank_id : 0,
            'supplier_branch' => $request->supplier_branch ? $request->supplier_branch : 0,
            'supplier_numbank' => $request->supplier_numbank ? $request->supplier_numbank : 0,
            'supplier_ownerbank' => $request->supplier_ownerbank ? $request->supplier_ownerbank : 0,
            'supplier_note' => $request->supplier_note ? $request->supplier_note : '',
        ]);
        return redirect()->route('supplier.index')->with('success', 'Thêm mới nhà cung cấp thành công.');
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
        $supplier = Supplier::find($id);
        return view('admin.components.supplier.editsupplier', compact('supplier'));
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
            'supplier_name' => 'required',
            'supplier_code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Supplier::find($id)->update([
            'supplier_name' => $request->supplier_name,
            'supplier_code' => $request->supplier_code,
            'supplier_note' => $request->supplier_note ? $request->supplier_note : '',
        ]);
        return redirect()->route('supplier.index')->with('success', 'Cập nhật nhà cung cấp thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Supplier::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa nhà cung cấp thành công.');
    }

    public function restore($id)
    {
        Supplier::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục nhà cung cấp thành công.');
    }

    public function destroy($id)
    {
        Supplier::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn nhà cung cấp thành công.');
    }
}
