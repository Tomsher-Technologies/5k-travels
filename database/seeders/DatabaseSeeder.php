<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\User::truncate(); 
           $users = [ 
            [ 
              'name' => 'Admin',
              'email' => 'admin@5k.com',
              'password' => '123456',
              'user_type' => 'admin',
            ]
          ];

          foreach($users as $user)
          {
            \App\Models\User::create([
               'name' => $user['name'],
               'email' => $user['email'],
               'user_type' => 'admin',
               'password' => Hash::make($user['password'])
             ]);
           }
    }
}

