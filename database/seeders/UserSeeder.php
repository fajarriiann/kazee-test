<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => '12345678'
        ]);

        $admin->assignRole('admin');

        $admin->userDetail()->create([
            'user_id' => $admin->id,
            'date_of_birth' => '2000-01-01',
            'phone_number' => '082134561424',
            'address' => 'Karanganyar Regency, Central Java, Indonesia'
        ]);
    }
}
