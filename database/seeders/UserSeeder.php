<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\LoginHistory;
use App\Models\SocialLogin;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(20)->has(Address::factory()->count(3))->has(SocialLogin::factory()->count(3))->has(LoginHistory::factory()->count(3))->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
