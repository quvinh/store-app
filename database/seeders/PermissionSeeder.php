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

            // Group
            // ['name' => 'gro.add', 'guard_name' => 'web'],
            // ['name' => 'gro.edit', 'guard_name' => 'web'],
            // ['name' => 'gro.delete', 'guard_name' => 'web'],
            // ['name' => 'gro.view', 'guard_name' => 'web'],

            // System
            ['name' => 'sys.add', 'guard_name' => 'web'],
            ['name' => 'sys.edit', 'guard_name' => 'web'],
            ['name' => 'sys.delete', 'guard_name' => 'web'],
            ['name' => 'sys.view', 'guard_name' => 'web'],

            // Report
            ['name' => 'rep.view', 'guard_name' => 'web'],

            // Log system
            ['name' => 'log.add', 'guard_name' => 'web'],
            ['name' => 'log.edit', 'guard_name' => 'web'],
            ['name' => 'log.delete', 'guard_name' => 'web'],
            ['name' => 'log.view', 'guard_name' => 'web'],
        ]);

        // Role
        $roleAdmin = Role::create(['name' => 'Administrator', 'guard_name' => 'web']);
        $rolePresident = Role::create(['name' => 'Giám đốc', 'guard_name' => 'web']);
        $roleAccount = Role::create(['name' => 'Kế toán', 'guard_name' => 'web']);
        $roleHR = Role::create(['name' => 'Quản lý nhân sự', 'guard_name' => 'web']);
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
        $roleEmployee->givePermissionTo(Permission::where([
            ['name', 'not like', 'acc%'],
            ['name', 'not like', 'sys%'],
            ['name', 'not like', 'war%'],
            ['name', 'not like', 'cus%'],
            ['name', 'not like', '%delete'],
            ['name', '<>', 'she.edit'],
        ])->get());

        // Assign role
        $admin = User::create([
            'name' => 'Ngô Quang Vinh',
            'username' => 'vinhhp',
            'email' => 'vinhhp2620@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-26',
        ]);
        $lvv = User::create([
            'name' => 'Higo',
            'username' => 'lvv',
            'email' => 'higo2952@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-01-11',
        ]);
        $quv = User::create([
            'name' => 'The King',
            'username' => 'qvuong',
            'email' => 'qvuong2106@gmail.com',
            'password' => bcrypt('123456'),
            'gender' => 1,
            'birthday' => '2000-06-21',
        ]);
        $admin->assignRole($roleAdmin);
        $lvv->assignRole($roleAdmin);
        $quv->assignRole($roleAdmin);
    }
}