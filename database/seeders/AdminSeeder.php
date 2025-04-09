<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admins = Admin::factory()->times(15)->has(User::factory(), 'user')->create();

       foreach ($admins as $admin)
       {
        $admin->user->assignRole('admin');
       }

    }
}
