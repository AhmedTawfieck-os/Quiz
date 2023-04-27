<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=User::create([
            "name"=>"admin", 
            "email"=>"admin@admin.com", 
            "password"=>Hash::make(12345678)
        ]);

        $admin->assignRole('admin');

        $user=User::create([
            "name"=>"user", 
            "email"=>"user@user.com", 
            "password"=>Hash::make(12345678)
        ]);

        $user->assignRole('member');
        //
    }
}
