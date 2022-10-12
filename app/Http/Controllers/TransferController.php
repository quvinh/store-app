<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TransferController extends Controller
{
    public static function Routes()
    {
        Route::group(['prefix' => 'transfer'], function () {
            Route::get('/', [TransferController::class, 'index'])->name('transfer.index');
            Route::get('/add', [TransferController::class, 'create'])->name('transfer.add');
            Route::post('/store', [TransferController::class, 'store'])->name('transfer.store');
            Route::get('/edit/{id}', [TransferController::class, 'edit'])->name('transfer.edit');
            Route::put('/update', [TransferController::class, 'update'])->name('transfer.update');
            Route::get('/delete/{id}', [TransferController::class, 'delete'])->name('transfer.delete');
            Route::get('/destroy/{id}', [TransferController::class, 'destroy'])->name('transfer.destroy');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Transfer::orderByDesc('id')->get();
        return view('admin.components.transfer.mantransfer', compact('transfers'));
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
