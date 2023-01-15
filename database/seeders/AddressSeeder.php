<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Address::truncate();
        Schema::enableForeignKeyConstraints();

        Address::factory()->count(5)->for(
            User::factory(),
            'addressable'
        )->create();

    }
}
