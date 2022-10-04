<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'group';
        $side['sub'] = 'country';
        $countries = Country::orderBy('country_name')->get();
        return view('admin.components.group.country', compact('side', 'countries'));
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
            'country_name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Country::create(
            [
                'country_name' => $request->country_name,
                'country_status' => 0,
            ]
        );
        return redirect()->back()->with('success', 'Thêm quốc gia thành công');
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
        $country = Country::find($id);
        if ($request->country_name != NULL || $request->country_name != '') {
            $country->update(
                [
                    'country_name' => $request->country_name,
                ]
            );
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }
        if ($request->country_status != NULL || intval($request->country_status) > 0) {
            if (intval($request->country_status) == 3) {
                $country->update(
                    [
                        'country_status' => 0,
                    ]
                );
                return redirect()->back()->with('success', 'Khôi phục thành công');
            }
            if ($country->country_status == 2) {
                $country->delete();
                return redirect()->back()->with('success', 'Xóa thành công');
            } else {
                $country->update(
                    [
                        'country_status' => $request->country_status,
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
