<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{
    public static function Routes()
    {
        // Route::get('warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');// ???
        Route::post('warehouse', [WarehouseController::class, 'store'])->name('warehouse.store');
        Route::get('warehouse/edit/{id}', [WarehouseController::class, 'edit'])->name('warehouse.edit');
        Route::get('warehouse/destroy/{id}', [WarehouseController::class, 'destroy'])->name('warehouse.destroy');
        Route::put('warehouse/update/{id}', [WarehouseController::class, 'update'])->name('warehouse.update');
        Route::get('warehouse', [WarehouseController::class, 'warehouseById'])->name('warehouse.warehouse-by-id');// ???
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.components.warehouse.manwarehouse', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.components.warehouse.addwarehouse');
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
            'warehouse_name' => 'required|unique:warehouses',
            'warehouse_code' => 'required|unique:warehouses',
            'warehouse_contact' => 'required',
            'warehouse_street' => 'required',
            // 'city_id' => 'required',
            // 'country_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        $image = '';
        $status = 0;
        $contact = str_replace([' ', '-', '(', ')', '+', '*', '.', '/'], '', $request->warehouse_contact);

        if ($request->hasFile('warehouse_image')) {

            $file = $request->file('warehouse_image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/warehouse/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/warehouse/', $name);
                $image = 'images/warehouse/' . $name;
            }
        }
        $data = [
            'warehouse_status' => $request->warehouse_status == 'on' ? '1' : '0',
            'warehouse_note' => $request->warehouse_note,
            'warehouse_image' => $image,
            'warehouse_contact' => $contact,
            'country_id' => '1',
            'city_id' => '1',
        ];

        Warehouse::create(array_merge(
            $validator->validated(),
            $data,
        ));
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Tạo mới kho "' . $request->warehouse_name . '"');
        return redirect()->back()->with('success', 'Tạo mới kho thành công');
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
        $warehouse = Warehouse::find($id);
        return view('admin.components.warehouse.editwarehouse', compact('warehouse'));
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
        $warehouse = Warehouse::find($id);
        $validator = Validator::make($request->all(), [
            'warehouse_name' => 'required|unique:warehouses,warehouse_name,' . $id,
            'warehouse_code' => 'required|unique:warehouses,warehouse_code,' . $id,
            'warehouse_contact' => 'required',
            'warehouse_street' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $image = $warehouse->warehouse_image;
        $status = 0;
        if ($request->warehouse_status == 'on') {
            $status = 1;
        }
        if ($request->hasFile('warehouse_image')) {
            $file = $request->file('warehouse_image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/warehouse/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/warehouse/', $name);
                $image = 'images/warehouse/' . $name;
            }
        }
        $data = [
            'warehouse_name' => $request->warehouse_name,
            'warehouse_code' => $request->warehouse_code,
            'warehouse_status' => $status,
            'warehouse_note' => $request->warehouse_note,
            'warehouse_image' => $image,
            'warehouse_contact' => $request->warehouse_contact,
        ];
        $warehouse->update($data);

        return redirect()->route('warehouse.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->delete();
        return redirect()->back()->with('success', 'xoa thành công');
    }

    public function warehouseById()
    {

        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        return view('admin.components.warehouse.manwarehouse', compact('warehouses'));
    }
}
