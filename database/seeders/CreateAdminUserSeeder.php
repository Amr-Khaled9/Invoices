<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Amr khaled',
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
            'role_name' => ['owner'],
            'Status' => 'مفعل'
        ]);
        $role = Role::create([
            'name' => 'Admin'
        ]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions(($permissions));
        $user->assignRole([$role->id]);
    }
}
