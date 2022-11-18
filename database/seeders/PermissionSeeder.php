<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission
        DB::table('permissions')->insert([
            // Item
            ['name' => 'ite.add', 'guard_name' => 'web'],
            ['name' => 'ite.edit', 'guard_name' => 'web'],
            ['name' => 'ite.delete', 'guard_name' => 'web'],
            ['name' => 'ite.view', 'guard_name' => 'web'],

            // Warehouse
            ['name' => 'war.add', 'guard_name' => 'web'],
            ['name' => 'war.edit', 'guard_name' => 'web'],
            ['name' => 'war.delete', 'guard_name' => 'web'],
            ['name' => 'war.view', 'guard_name' => 'web'],

            // Shelf
            ['name' => 'she.add', 'guard_name' => 'web'],
            ['name' => 'she.edit', 'guard_name' => 'web'],
            ['name' => 'she.delete', 'guard_name' => 'web'],
            ['name' => 'she.view', 'guard_name' => 'web'],

            // Category
            ['name' => 'cat.add', 'guard_name' => 'web'],
            ['name' => 'cat.edit', 'guard_name' => 'web'],
            ['name' => 'cat.delete', 'guard_name' => 'web'],
            ['name' => 'cat.view', 'guard_name' => 'web'],

            // Export and Import
            ['name' => 'eim.add', 'guard_name' => 'web'],
            ['name' => 'eim.edit', 'guard_name' => 'web'],
            ['name' => 'eim.delete', 'guard_name' => 'web'],
            ['name' => 'eim.view', 'guard_name' => 'web'],

            // Transfer
            ['name' => 'tra.add', 'guard_name' => 'web'],
            ['name' => 'tra.edit', 'guard_name' => 'web'],
            ['name' => 'tra.delete', 'guard_name' => 'web'],
            ['name' => 'tra.view', 'guard_name' => 'web'],

            // Inventory
            ['name' => 'inv.add', 'guard_name' => 'web'],
            ['name' => 'inv.edit', 'guard_name' => 'web'],
            ['name' => 'inv.delete', 'guard_name' => 'web'],
            ['name' => 'inv.view', 'guard_name' => 'web'],

            // Account
            ['name' => 'acc.add', 'guard_name' => 'web'],
            ['name' => 'acc.edit', 'guard_name' => 'web'],
            ['name' => 'acc.delete', 'guard_name' => 'web'],
            ['name' => 'acc.view', 'guard_name' => 'web'],

            // Unit
            ['name' => 'uni.add', 'guard_name' => 'web'],
            ['name' => 'uni.edit', 'guard_name' => 'web'],
            ['name' => 'uni.delete', 'guard_name' => 'web'],
            ['name' => 'uni.view', 'guard_name' => 'web'],

            // Supplier
            ['name' => 'sup.add', 'guard_name' => 'web'],
            ['name' => 'sup.edit', 'guard_name' => 'web'],
            ['name' => 'sup.delete', 'guard_name' => 'web'],
            ['name' => 'sup.view', 'guard_name' => 'web'],

            // System
            ['name' => 'sys.add', 'guard_name' => 'web'],
            ['name' => 'sys.edit', 'guard_name' => 'web'],
            ['name' => 'sys.delete', 'guard_name' => 'web'],
            ['name' => 'sys.view', 'guard_name' => 'web'],

            // Statistic
            ['name' => 'sta.view', 'guard_name' => 'web'],

            // Log system
            ['name' => 'log.view', 'guard_name' => 'web'],
        ]);

        // Role
        $roleAdmin = Role::create(['name' => 'Administrator', 'guard_name' => 'web']);
        $rolePresident = Role::create(['name' => 'Giám đốc', 'guard_name' => 'web']);
        $roleAccount = Role::create(['name' => 'Kế toán', 'guard_name' => 'web']);
        $roleHR = Role::create(['name' => 'Quản lý nhân sự', 'guard_name' => 'web']);
        $roleStore = Role::create(['name' => 'Thủ kho', 'guard_name' => 'web']);
        $roleEmployee = Role::create(['name' => 'Nhân viên', 'guard_name' => 'web']);

        // Give permission
        $roleAdmin->givePermissionTo(Permission::all());
        $rolePresident->givePermissionTo(Permission::all());
        $roleHR->givePermissionTo(Permission::where([
            ['name', 'like', 'acc%'],
        ])->get());
        $roleAccount->givePermissionTo(Permission::where([
            ['name', 'not like', 'acc%'],
            ['name', 'not like', 'sys%'],
        ])->get());
        $roleStore->givePermissionTo(Permission::where([
            ['name', 'not like', 'acc%'],
            ['name', 'not like', 'sys%'],
            ['name', 'not like', 'war%'],
            ['name', 'not like', '%edit'],
            ['name', 'not like', '%delete'],
            ['name', '<>', 'she.edit'],
        ])->get());
        $roleEmployee->givePermissionTo(Permission::where([
            ['name', 'like', 'war.view'],
        ])->get());

        // Assign role
        $admin = User::create([
            'name' => 'Ngô Quang Vinh',
            'username' => 'vinhhp',
            'email' => 'vinhhp2620@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-26',
            'address' => 'Hai Phong',
            'mobile' => '0962334135',
        ]);
        $lvv = User::create([
            'name' => 'Higo',
            'username' => 'lvv',
            'email' => 'higo2952@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-01-11',
            'address' => 'Hai Phong',
            'mobile' => '0962334136',
        ]);
        $quv = User::create([
            'name' => 'The King',
            'username' => 'qvuong',
            'email' => 'qvuong2106@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
            'address' => 'Hai Phong',
            'mobile' => '0962334137',
        ]);
        $giamdoc = User::create([
            'name' => 'Giám Đốc',
            'username' => 'giamdoc',
            'email' => 'giamdoc@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
            'address' => 'Hai Phong',
            'mobile' => '0962334127',
        ]);
        $ketoan = User::create([
            'name' => 'Kế toán',
            'username' => 'ketoan',
            'email' => 'ketoan@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
            'address' => 'Hai Phong',
            'mobile' => '0962334127',
        ]);
        $thukho = User::create([
            'name' => 'Thủ kho',
            'username' => 'thukho',
            'email' => 'thukho@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
            'address' => 'Hai Phong',
            'mobile' => '0962334127',
        ]);
        $nhanvien = User::create([
            'name' => 'Nhân viên',
            'username' => 'nhanvien',
            'email' => 'nhanvien@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
            'address' => 'Hai Phong',
            'mobile' => '0962334127',
        ]);
        $admin->assignRole($roleAdmin);
        $lvv->assignRole($roleAdmin);
        $quv->assignRole($roleAdmin);
        $giamdoc->assignRole($rolePresident);
        $ketoan->assignRole($roleAccount);
        $thukho->assignRole($roleStore);
        $nhanvien->assignRole($roleEmployee);
    }
}
