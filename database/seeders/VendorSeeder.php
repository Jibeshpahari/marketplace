<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Vendor',
            'email'    => 'vendor@vendor.com',
            'password' => Hash::make('password'),
            'role'     => 'vendor',
        ]);
    }
}
