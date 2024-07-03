<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bafskbus.com',
            'password' => Hash::make('!@#SecRet23'),
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@bafskbus.com',
            'password' => Hash::make('!@#SecRet23'),
        ]);
    }
}
