<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        User::create([
            'nom' => $faker->firstName(),
            'prenom' => $faker->lastName(),
            'email' => 'admin@test.com',
            'telephone' => $faker->phoneNumber(),
            'role' => 1,
            'folder' => hexdec(uniqid()),
            'email_verified_at' => now(),
            'password' => Hash::make('admin')
        ]);
        User::create([
            'nom' => $faker->firstName(),
            'prenom' => $faker->lastName(),
            'email' => 'conseiller@test.com',
            'telephone' => $faker->phoneNumber(),
            'role' => 2,
            'folder' => hexdec(uniqid()),
            'email_verified_at' => now(),
            'password' => Hash::make('conseiller')
        ]);
        User::create([
            'nom' => $faker->firstName(),
            'prenom' => $faker->lastName(),
            'email' => 'porteur@test.com',
            'telephone' => $faker->phoneNumber(),
            'role' => 3,
            'folder' => hexdec(uniqid()),
            'status' => 'PARTICULIER',
            'email_verified_at' => now(),
            'password' => Hash::make('porteur')
        ]);
        User::create([
            'nom' => $faker->firstName(),
            'prenom' => $faker->lastName(),
            'email' => 'investisseur@test.com',
            'telephone' => $faker->phoneNumber(),
            'role' => 4,
            'folder' => hexdec(uniqid()),
            'status' => 'PARTICULIER',
            'email_verified_at' => now(),
            'password' => Hash::make('investisseur')
        ]);
    }
}
