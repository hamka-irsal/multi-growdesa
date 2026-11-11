<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        /*
    |--------------------------------------------------------------------------
    | Create Role Superadmin
    |--------------------------------------------------------------------------
    */

        $superadminRole = Role::firstOrCreate([
            'name'       => 'superadmin',
            'guard_name' => 'api',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Assign All Permissions to Superadmin
    |--------------------------------------------------------------------------
    */

        $permissions = Permission::all();

        $superadminRole->syncPermissions($permissions);

        /*
    |--------------------------------------------------------------------------
    | Create Superadmin User
    |--------------------------------------------------------------------------
    */

        $superadmin = User::create([
            'name'              => 'Superadmin GrowDesa',
            'email'             => 'superadmin@growdesa.id',
            'password'          => bcrypt('password'),
            'desa_id'           => null,
            'role'              => 'superadmin',
            'status_verifikasi' => 'disetujui',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Assign Role to User
    |--------------------------------------------------------------------------
    */

        $superadmin->assignRole($superadminRole);
    }
}
