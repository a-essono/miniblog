<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exécute la méthode `run()` de RolesAndPermissionsSeeder::class
        $this->call(RolesAndPermissionsSeeder::class);
        // Exécute la méthode `run()` de UsersSeeder::class
        $this->call(UsersSeeder::class);

        // Existe par défaut à la cration du seeders, un afichier spécifique 
        // et adaptés aux rôles et permissions d'utilisateurs fictifs sera créé pour cette tâche 
        // User::factory(10)->create(); le 10 pour créer 10 utilisateurs fictifs
        // User::factory()->create(); créé un utilisateur par défaut (à enlever si on en veut aucun)
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
