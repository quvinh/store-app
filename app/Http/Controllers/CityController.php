<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'group';
        $side['sub'] = 'city';
        $cities = City::orderBy('city_name')->get();
        $countries = Country::orderBy('country_name')->get();
        return view('admin.components.group.city', compact('side', 'countries', 'cities'));
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
            'country_id' => 'required',
            'city_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        City::create(
            [
                'city_name' => $request->city_name,
                'country_id' => $request->country_id,
                'city_status' => 0,
            ]
        );
        return redirect()->back()->with('success', 'Thêm tỉnh thành công');
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
        $city = City::find($id);
        if ($request->city_name != NULL || $request->city_name != '') {
            $city->update(
                [
                    'city_name' => $request->city_name,
                ]
            );
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }
        if ($request->city_status != NULL || intval($request->city_status) > 0) {
            if (intval($request->city_status) == 3) {
                $city->update(
                    [
                        'city_status' => 0,
                    ]
                );
                return redirect()->back()->with('success', 'Khôi phục thành công');
            }
            if ($city->city_status == 2) {
                $city->delete();
                return redirect()->back()->with('success', 'Xóa thành công');
            } else {
                $city->update(
                    [
                        'city_status' => $request->city_status,
                    ]
                );
                return redirect()->back()->with('success', 'Cập nhật thành công');
            }
        }
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
