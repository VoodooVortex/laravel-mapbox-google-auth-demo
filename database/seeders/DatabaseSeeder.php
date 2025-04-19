<?php

namespace Database\Seeders;

use App\Models\Role;
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

        // User::factory()->create([
        //     'name' => 'PK',
        //     'email' => 'pakkapon2547@gmail.com',
        //     'role' => 'admin',
        // ]);
        /* The code snippet `User::create([...]);` is creating a new user record in the database. Here's a
breakdown of the data being passed to the `create` method: */

        User::create([
            'name' => 'PK',
            'email' => 'pakkapon2547@gmail.com',
            'role' => 'admin',
        ]);
    }
}
