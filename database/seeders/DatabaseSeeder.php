<?php

namespace Database\Seeders;

use App\Models\Compro;
use App\Models\Portfolio;
use App\Models\Property;
use App\Models\Testimony;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'administrator@gmail.com',
            'phone' => '1234567891',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'Agent',
            'username' => 'agent',
            'email' => 'agent@gmail.com',
            'phone' => '1231231231',
            'password' => bcrypt('password'),
            'role' => 'agent',
            'email_verified_at' => now(),
        ]);

        User::factory()->create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'phone' => '2342342342',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        Compro::create([
            'name' => 'Domus Mea',
            'about' => 'Domus Mea adalah blablablablablablablablabla',
            'address' => 'Jl. Kp. Poncol No.41, Tanah Baru, Kecamatan Beji, Kota Depok, Jawa Barat 16426',
            'phone' => '089674002822',
            'email' => 'domusmea@gmail.com'
        ]);

        Portfolio::factory(10)->create();
        Property::factory(10)->create();
        Testimony::factory(10)->create();
    }
}
