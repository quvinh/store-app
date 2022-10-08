<?php

namespace App\Http\Controllers;
use App\Jobs\SendMail;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    public static function Routes()
    {
        Route::get('account', [AccountController::class, 'index'])->name('account.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'account';
        $side['sub'] = 'manaccount';
        $accounts = User::all();
        return view('admin.components.account.manaccount', compact('side', 'accounts'));
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'gender' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/account/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/account/', $name);
                $image = 'images/account/' . $name;
            }
        }
        User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'image' => $image,
            ]
        ));

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'content' => 'Bạn đã được kích hoạt tài khoản quản trị trên 3vsoft.',
        ];

        SendMail::dispatch($data)->delay(now()->addMinute(1));
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Tạo mới tài khoản "' . $request->name . '"');
        return redirect()->back()->with('success', 'Tạo mới tài khoản thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findById($id);
        $permission = $role->getAllPermissions();
        return response()->json([
            'data' => $permission->pluck('name')->toArray(),
            'name' => $role->name,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $side['header'] = 'account';
        $side['sub'] = 'manaccount';
        $account = User::find($id);
        $roles = Role::all();
        return view('admin.components.account.editaccount', compact('side', 'account', 'roles'));
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
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = User::find($id);
        $user->assignRole($request->role);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Cập nhật nhóm quyền cho tài khoản "' . $user->name . '"');
        return redirect()->route('account.index')->with('success', 'Cập nhật tài khoản "' . $user->name . '" thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        Log::info('[DELETE] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Xóa tài khoản');
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function info()
    {
        $side['header'] = 'info';
        $side['sub'] = '';
        $id = Auth::user()->id;
        $user = User::find($id);
        $address = Address::where('user_id', $id);
        return view('admin.components.account.setting', compact('side', 'user', 'address'));
    }

    public function general(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $id = Auth::user()->id;
        $user = User::find($id);
        $image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/account/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/account/', $name);
                $image = 'images/account/' . $name;
            }
            if (file_exists($user->image)) {
                File::delete($user->image);
            }
        } else {
            $image = $user->image;
        }
        $date = str_replace('/', '-', $request->birthday);
        $birthday = date('Y-m-d', strtotime($date));
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $image,
            'gender' => $request->gender,
            'birthday' => $birthday,
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Cập nhật thông tin tài khoản');
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpswd' => 'required',
            'password' => 'required|different:oldpswd|confirmed'
        ]);
        if ($validator->fails()) {
            return redirect('/account/info#change-password')->withErrors($validator);
        }
        $id = Auth::user()->id;
        $user = User::find($id);
        // dd($request->all(), $user, Hash::check($request->oldpswd, $user->password));
        if (Hash::check($request->oldpswd, $user->password)) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
            Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Thay đổi mật khẩu');
            return redirect('/account/info#change-password')->with('success', 'Mật khẩu đã thay đổi');
        } else {
            return redirect('/account/info#change-password')->with('error', 'Mật khẩu cũ không đúng');
        }
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_street' => 'required',
            'address_phone' => 'required',
            'city_id' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/account/info#info')->withErrors($validator);
        }
        $id = Auth::user()->id;
        $phone = str_replace([' ', '-', '(', ')', '+', '*', '.', '/'], '', $request->address_phone);
        Address::create([
            'user_id' => $id,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'address_street' => $request->address_street,
            'address_phone' => $phone,
            'address_status' => 0,
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Thêm địa chỉ');
        return redirect('/account/info#info')->with('success', 'Lưu thành công');
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/account/info#info')->withErrors($validator);
        }
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        foreach($addresses as $address) {
            Address::find($address->id)->update([
                'address_status' => 0
            ]);
        }
        Address::find($request->address)->update([
            'address_status' => 1
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Cập nhật địa chỉ');
        return redirect('/account/info#info')->with('success', 'Cập nhật thành công');
    }
}
