<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public static function Routes() {
        Route::group(['prefix' => 'role'], function() {
            Route::get('/', [RoleController::class, 'index'])->name('role.index');
            Route::post('/add', [RoleController::class, 'store'])->name('role.store');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('role.update');
            Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('role.delete');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderByDesc('id')->get();
        return view('admin.components.role.manrole', compact('roles'));
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
            'name' => 'required|unique:roles'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        $role->givePermissionTo(Permission::where([
            ['name', 'not like', 'acc%'],
            ['name', 'not like', 'sys%'],
            ['name', 'not like', 'war%'],
            ['name', 'not like', 'cus%'],
            ['name', 'not like', 'log%'],
            ['name', 'not like', '%delete'],
            ['name', '<>', 'she.edit'],
        ])->get());

        return redirect()->back()->with('success', 'Lưu nhóm thành công');
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
        $side['header'] = 'system';
        $side['sub'] = 'role';
        $groups = array(
            'ite' => 'Vật tư',
            'war' => 'Kho vật tư',
            'she' => 'Giá/kệ',
            'cat' => 'Danh mục',
            'eim' => 'Xuất Nhập kho',
            'tra' => 'Chuyển kho',
            'inv' => 'Kiểm kho',
            'acc' => 'Tài khoản',
            'sys' => 'Hệ thống',
            'rep' => 'Báo cáo',
            'log' => 'Logs hệ thống',
        );
        $role = Role::findById($id);
        $permission = $role->getAllPermissions();
        return view('admin.components.role.editrole', compact('side', 'role', 'groups', 'permission'));
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
            'permission' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $permission = explode(',', $request->permission);
        $role = Role::findById($id);
        $role->update([
            'name' => $request->role,
        ]);
        $role->syncPermissions();
        $role->givePermissionTo($permission);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findById($id);
        $userCount = User::role($role->name)->count();
        if($userCount>0) {
            return redirect()->back()->with('error', 'Một vài tài khoản đang theo nhóm này, không thể xóa');
        } else {
            $role->delete();
            return redirect()->back()->with('success', 'Xóa nhóm thành công');
        }
    }
}
