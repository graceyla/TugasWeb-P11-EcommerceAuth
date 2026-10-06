<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Akun untuk testing (password semua: password)
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin Toko',
            'email' => 'admin@tokokita.test',
        ]);

        User::factory()->editor()->create([
            'name' => 'Editor Satu',
            'email' => 'editor@tokokita.test',
        ]);

        User::factory()->editor()->create([
            'name' => 'Editor Dua',
            'email' => 'editor2@tokokita.test',
        ]);

        User::factory()->create([
            'name' => 'Pembeli Biasa',
            'email' => 'user@tokokita.test',
        ]);

        // pembeli lain
        User::factory(15)->create();

        // setiap user role "user" punya 1-2 alamat, yang pertama jadi alamat utama
        User::where('role', User::ROLE_USER)->each(function (User $user) {
            Address::factory()->for($user)->create([
                'recipient_name' => $user->name,
                'is_default' => true,
            ]);

            if (fake()->boolean(40)) {
                Address::factory()->for($user)->create(['recipient_name' => $user->name]);
            }
        });
    }
}
