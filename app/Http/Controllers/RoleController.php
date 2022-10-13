<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public static function Routes()
    {
        Route::group(['prefix' => 'role'], function() {
            Route::get('/', [RoleController::class, 'index'])->name('admin.role');
            Route::post('/add', [RoleController::class, 'store'])->name('admin.role.add');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
            Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('admin.role.delete');
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
            'name' => 'required|unique:roles',
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

        return redirect()->back()->with(['success' => 'Added successfully']);
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
        $groups = array(
            'pat' => Lang::get('components/role.patient'),
            'gro' => Lang::get('components/role.group'),
            'sta' => Lang::get('components/role.station'),
            'typ' => Lang::get('components/role.type'),
            'inv' => Lang::get('components/role.invoice'),
            'not' => Lang::get('components/role.notify'),
            'acc' => Lang::get('components/role.account'),
            'print' => Lang::get('components/role.print'),
            'price' => Lang::get('components/role.price'),
            'exc' => Lang::get('components/role.excel'),
            'doc' => Lang::get('components/role.doctor'),
            'sam' => Lang::get('components/role.sample'),
            'rep' => Lang::get('components/role.report'),
            'log' => Lang::get('components/role.log'),
        );
        $role = Role::findById($id);
        $permission = $role->getAllPermissions();
        return view('admin.components.role.editrole', compact('groups', 'role', 'permission'));
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

        // $permission = explode(',', $request->permission);
        $permission = array();
        $permissions = Permission::all('name')->pluck('name');
        $data = explode(',', $request->permission);
        foreach($data as $value) {
            if(in_array($value, $permissions->toArray())) {
                array_push($permission, $value);
            }
        }
        $role = Role::findById($id);
        $role->update([
            'name' => $request->role,
        ]);
        $role->syncPermissions();
        $role->givePermissionTo($permission);
        return redirect()->back()->with(['success' => 'Updated successfully']);
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
            return redirect()->back()->with(['error' => 'Một vài tài khoản đang theo nhóm này, không thể xóa']);
        } else {
            $role->delete();
            return redirect()->back()->with(['success' => 'Deleted successfully']);
        }
    }
}
