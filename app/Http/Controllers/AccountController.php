<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Models\Address;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        Route::group(['prefix' => 'account'], function () {
            Route::group(['middleware' => ['can:acc.edit']], function () {
                Route::get('/show/{id}', [AccountController::class, 'show'])->name('account.show');
                Route::put('/edit/{id}', [AccountController::class, 'edit'])->name('account.edit');
            });
            Route::get('/', [AccountController::class, 'index'])->name('account.index')->middleware(['can:acc.view']);
            Route::group(['middleware' => ['can:acc.add']], function () {
                Route::get('/create', [AccountController::class, 'create'])->name('account.create');
                Route::post('/store', [AccountController::class, 'store'])->name('account.store');
            });
            Route::get('/delete/{id}', [AccountController::class, 'destroy'])->name('account.destroy')->middleware(['can:acc.delete']);

            Route::put('/update/{id}', [AccountController::class, 'update'])->name('account.profile.update');
            Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
            Route::put('/change-password/{id}', [AccountController::class, 'changePassword'])->name('account.change-password');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = User::orderByDesc('id')->get();
        return view('admin.components.account.manaccount', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.components.account.addaccount');
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
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $gender = ($request->male == '1') ? '1' : '0';
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
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $gender,
            'image' => $image,
            'birthday' => $request->birthday
        ]);
        WarehouseManager::create([
            'user_id' => $user->id,
            'warehouse_id' => Warehouse::all()->first()->id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'content' => 'Bạn đã được kích hoạt tài khoản quản trị trên 3vsoft.',
        ];

        // SendMail::dispatch($data)->delay(now()->addMinute(1));
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
        $account = User::find($id);
        $warehouse = DB::table('warehouses')->where('warehouse_status', '1')->get();
        $manager = DB::table('warehouse_managers')->where('user_id', $account->id)->pluck('warehouse_id');
        $roles = Role::all();
        return view('admin.components.account.editaccount', compact('account', 'warehouse', 'manager', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'birthday' => 'required',
            'username' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user = User::find($id);
        $user->assignRole($request->role);

        if ($request->warehouse) {
            DB::table('warehouse_managers')->where('user_id', $id)->delete();
            $warehouses = $request->warehouse;
            foreach ($warehouses as $warehouses) {
                WarehouseManager::create([
                    'user_id' => $id,
                    'warehouse_id' => $warehouses
                ]);
            }
        }
        $image = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/uploads/account/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/uploads/account/', $name);
                $image = 'images/uploads/account/' . $name;
            }
            if (file_exists($user->image)) {
                File::delete($user->image);
            }
        } else {
            $image = $user->image;
        }
        $gender = $request->male == '1' ? '1' : $request->female;
        User::find($request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'image' => $image,
            'username' => $request->username,
            'gender' => $gender,
        ]);
        return redirect()->route('account.index')->with(['success' => 'Updated successfully']);
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
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = User::find($id);
        $image = '';
        // $gender = $request->male == '1' ? '1' : $request->female;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/uploads/account/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/uploads/account/', $name);
                $image = 'images/uploads/account/' . $name;
            }
            if (file_exists($user->image)) {
                File::delete($user->image);
            }
        } else {
            $image = $user->image;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'image' => $image,
            'username' => $request->username,
            'gender' => $request->gender,
        ]);
        return redirect()->route('admin.profile')->with(['success' => 'Updated successfully']);
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



    public function changePassword(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = User::find($id);
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors('Mật khẩu không trùng khớp mời nhập lại!! ');
        } else {
            User::find($id)->update([
                'password' => Hash::make($request->new_password),
            ]);
        }
        return redirect()->route('account.profile')->with(['success' => 'Updated successfully']);
    }

    public function profile()
    {
        $profile = User::find(Auth::user()->id);
        return view('admin.components.account.manprofile', compact('profile'));
    }
}
