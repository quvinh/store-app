<?php

namespace App\Http\Controllers;

use App\Jobs\ResetPassMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FogotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.forgotpassword');
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
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }
        $user = User::where('email', $request->email);
        if ($user->first() == NULL) {
            return redirect()->back()->withErrors(['message' => 'Email không tồn tại trong hệ thống'])->withInput($request->input());
        } else {
            $newpswd = Str::random(6) . '123@';
            $user->update([
                'password' => bcrypt($newpswd),
            ]);

            $data = [
                'name' => $user->first()->name,
                'email' => $user->first()->email,
                'username' => $user->first()->username,
                'password' => $newpswd,
                'content' => 'Lấy lại mật khẩu thành công. Bạn có thể thay đổi mật khẩu mới khác bằng cách vào "Thông tin tài khoản" >> "Đổi mật khẩu" với thông tin tài khoản của mình ở bên dưới.',
            ];
            ResetPassMail::dispatch($data)->delay(now()->addMinute(1));
            Log::alert('[' . $request->getMethod() . '] (' . $user->first()->username . ')' . $user->first()->name . ' >> Lấy lại mật khẩu thành công');
            return redirect()->back()->with(['success' => 'Hoàn thành! Mật khẩu mới đã được gửi về hòm thư ' . $request->email]);
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
