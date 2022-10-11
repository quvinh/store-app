<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExImport;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ExportImportController extends Controller
{

    public static function Routes()
    {
        Route::get('ex_import', [ExportImportController::class, 'index'])->name('ex_import.index');
        Route::get('import', [ExportImportController::class, 'import'])->name('ex_import.import');
        Route::post('imstore', [ExportImportController::class, 'imstore'])->name('ex_import.imstore');
        Route::get('export', [ExportImportController::class, 'export'])->name('ex_import.export');
        Route::post('exstore', [ExportImportController::class, 'exstore'])->name('ex_import.exstore');
        Route::group(['prefix' => 'ex_import'], function () {
            Route::get('/delete/{id}', [ExportImportController::class, 'delete'])->name('ex_import.delete');
            Route::get('/restore/{id}', [ExportImportController::class, 'restore'])->name('ex_import.restore');
            Route::get('/destroy/{id}', [ExportImportController::class, 'destroy'])->name('ex_import.destroy');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $im_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->where('ex_imports.exim_type', 1)
            ->select('ex_imports.*')->get();
        $ex_items = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->where('ex_imports.exim_type', 0)
            ->select('ex_imports.*')->get();
        return view('admin.components.ex_import.manex_import', compact('im_items', 'ex_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $units = Unit::all();
        $items = DB::table('items')->whereNull('deleted_at')->get();
        return view('admin.components.ex_import.import', compact('categories', 'suppliers', 'units', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imstore(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($id)
    {
        $warehouse = Unit::all();
        $items = DB::table('items')->whereNull('deleted_at')->get();
        return view('admin.components.ex_import.import', compact('warehouses', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exstore($id)
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
        ExImport::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa nhà cung cấp thành công.');
    }

    public function restore($id)
    {
        ExImport::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục nhà cung cấp thành công.');
    }

    public function destroy($id)
    {
        ExImport::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn nhà cung cấp thành công.');
    }
}
