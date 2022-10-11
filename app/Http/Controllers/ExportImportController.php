<?php

namespace App\Http\Controllers;
use App\Models\ExImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ExportImportController extends Controller
{

    public static function Routes(){
        Route::get('eximport', [ExportImportController::class, 'index' ])->name('eximport.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'exportimport';
        $side['sub'] = 'manexportimport';
        $exim = ExImport::all();
        return view('admin.components.exportimport.manexportimport', compact('side', 'exim'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $side['header'] = 'exportimport';
        $side['sub'] = 'addexportimport';
        return view('admin.components.exportimport.addexportimport', compact('side'));
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
    public function destroy($id)
    {
        //
    }
}
