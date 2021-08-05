<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        foreach ($permissions as $permission) {
            Permission::query()->firstOrCreate(['name' => $permission], ['guard_name' => 'admin']);
        }
    }
}
