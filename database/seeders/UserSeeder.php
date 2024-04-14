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
        /* $role = Role::findOrFail(1);
        $role->givePermissionTo(Permission::all());
 */
        /* $user = User::create([
            'name'=>'Admin',
            'email'=>'payscope@admin.com',
            'password'=>Hash::make('Payscope@123#')
        ]); 

        $user->assignRole('super-admin');
        Wallet::create([
            'user_id'=>$user->id
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
    }
}
