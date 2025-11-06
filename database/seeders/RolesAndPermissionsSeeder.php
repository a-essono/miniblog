<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Toujours vider le cache interne de Spatie avant d'altérer la matrice
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Permissions spécifiques au projet, ici liées aux articles (MiniBlog)
        $perms = [
            'posts.view', // Affichage d'un article
            'posts.create',
            'posts.edit',
            'posts.delete',
            'posts.publish',
            'users.manage', // Gestion des utilisateurs
        ];
        // Ajoute les permissions `$perms` dans la BDD en firstOrCreate.
		// permission::firstOrCreate() vérifie l'existence de la permission
		// Si existe la récupère sinon la crée
        foreach ($perms as $p) {
            Permission::firstOrCreate((['name' => $p]));
        }

        // Rôles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $author = Role::firstOrCreate(['name' => 'author']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // Matrice rôles -> permissoons
        $admin->syncPermissions(Permission::all());
        $editor->syncPermissions(['posts.view', 'posts.create', 'posts.edit', 'posts.publish']);
        $author->syncPermissions(['posts.view', 'posts.create', 'posts.edit']);
        $viewer->syncPermissions(['posts.view']);

        // Rafraîchir le cache des permissions 
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
