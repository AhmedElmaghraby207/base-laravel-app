<?php

namespace Database\Seeders;

use App\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::query()->firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => md5('password')]
        );
        $admin->assignRole('Administrator');
    }
}
