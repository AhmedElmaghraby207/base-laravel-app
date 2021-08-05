<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Administrator',
            'Creator',
            'Editor',
            'Reader',
        ];

        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'patient-list',
            'patient-create',
            'patient-edit',
            'patient-delete',
            'announcement-create',
            'notification_template-list',
            'notification_template-edit',
            'setting-list',
            'setting-edit',
        ];

        foreach ($roles as $role) {
            $created_role = Role::query()->firstOrCreate(['name' => $role], ['guard_name' => 'admin']);
            $created_role->syncPermissions($permissions);
        }
    }
}
