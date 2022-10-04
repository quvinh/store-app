<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'warehouse';
        $side['sub'] = 'manwarehouse';
        $warehouses = Warehouse::all();
        return view('admin.components.warehouse.manwarehouse', compact('side', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $side['header'] = 'warehouse';
        $side['sub'] = 'addwarehouse';

        return view('admin.components.warehouse.addwarehouse', compact('side'));
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
            'country_id' => 'required',
            'city_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $image = '';
        $status = 0;
        $contact = str_replace([' ', '-', '(', ')', '+', '*', '.', '/'], '', $request->warehouse_contact);
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
        Warehouse::create(array_merge(
            $validator->validated(),
            [
                'warehouse_status' => $status,
                'warehouse_note' => $request->warehouse_note,
                'warehouse_image' => $image,
                'warehouse_contact' => $contact,
            ]
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
