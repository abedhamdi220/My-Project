<?php

namespace Database\Seeders;

use App\Enums\RoleUserEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [RoleUserEnum::Admin, RoleUserEnum::Provider, RoleUserEnum::Client];

        foreach($users as $user){
            User::create([
                "name" => $user,
                "email" => "$user@gmail.com",
                "password" => Hash::make("Password@123"),
                "role" => $user
            ]);
        }
    }
}
