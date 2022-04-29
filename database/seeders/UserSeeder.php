<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => config('userseeder.users.1.name'),
            'email' => config('userseeder.users.1.email'),
            'password' => config('userseeder.users.1.password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'azure_id' => config('userseeder.users.1.azure_id'),
            'active' => config('userseeder.users.1.active'),
        ]);

        User::create([
            'name' => config('userseeder.users.2.name'),
            'email' => config('userseeder.users.2.email'),
            'password' => config('userseeder.users.2.password'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'azure_id' => config('userseeder.users.2.azure_id'),
            'active' => config('userseeder.users.2.active'),
        ]);

    }
}
