<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Seven Admin',
                'email' => 'admin7@sipambelum.com',
                'email_verified_at' => date('Y-m-d H:i:s', time()),
                'password' => \bcrypt('password'),
                'role' => '70x7'
            ]
        );
    }
}