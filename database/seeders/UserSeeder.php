<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /*   Permission::create([
            'name' => 'role-create',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-list',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-edit',
            'group'=>'role'
        ]);
        Permission::create([
            'name' => 'role-delete',
            'group'=>'role'
        ]); */
        // print_r(Permission::all());
        // die;
<<<<<<< HEAD
<<<<<<< HEAD
        $role = Role::findOrFail(1);
        $role->givePermissionTo(Permission::all());
        $user = User::create([
            'name'=>'Admin',
            'email'=>'payscope@admin.com',
            'password'=>Hash::make('Payscope@123#'),
            'virtual_account_number'=>'ZGROSC9519035604',
            'mobile_no'=>'9519035604'
=======
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
        /* $role = Role::findOrFail(1);
        $role->givePermissionTo(Permission::all());
 */
        /* $user = User::create([
            'name'=>'Admin',
            'email'=>'payscope@admin.com',
            'password'=>Hash::make('Payscope@123#')
<<<<<<< HEAD
>>>>>>> bde5cc6 (again setup)
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
        ]); 

        $user->assignRole('super-admin');
        Wallet::create([
            'user_id'=>$user->id
<<<<<<< HEAD
<<<<<<< HEAD
        ]);

        // Status::create([
        //     'name'=>'pending'
        // ]);
        // Status::create([
        //     'name'=>'approved'
        // ]);
        // Status::create([
        //     'name'=>'rejected'
        // ]);
=======
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
        ]); */

        Status::create([
            'name'=>'pending'
        ]);
        Status::create([
            'name'=>'approved'
        ]);
        Status::create([
            'name'=>'rejected'
        ]);
<<<<<<< HEAD
>>>>>>> bde5cc6 (again setup)
=======
>>>>>>> edbb7088ad7a904f2f91b646a4572c9f89e9528b
    }
}
