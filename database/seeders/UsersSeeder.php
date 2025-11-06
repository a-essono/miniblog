<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Post;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'toto@mail.com',
                'name' => 'Toto Admin',
                'password' => 'totototo',
                'role' => 'admin'
            ],
            [
                'email' => 'titi@mail.com',
                'name' => 'Titi Editor',
                'password' => 'titititi',
                'role' => 'editor'
            ],
            [
                'email' => 'tata@mail.com',
                'name' => 'Tata Author',
                'password' => 'tatatata',
                'role' => 'author'
            ],
            [
                'email' => 'tutu@mail.com',
                'name' => 'Tutu Author',
                'password' => 'tututu',
                'role' => 'viewer'
            ]
        ];

        foreach ($users as $u) {
            $newUser = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']), // Chiffre le mot de passe avant stockage (sécurité)
                    'email_verified_at' => now(), // Marque l’utilisateur comme ayant vérifié son adresse e-mail (no mail confirmation)
                    // 'remembre_token' => Str::random(60), // token unique pour chaque utilisateur
                ]
                );

                $newUser->syncRoles([$u['role']]);

                Post::factory(6)->for($newUser)->create();
        }
    }
}
