<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool
    {
        if ($post->status === 'published') {
            return true;
        }

        return $user?->id === $post->user_id || 
        $user?->hasRole(['editor', 'admin']);
    }

    /**
     * Determine whether the user can create models.
     * Peut créer si permissio
     */
    public function create(User $user): bool
    {
        return $user->can('posts.create');
    }

    /**
     * Determine whether the user can update the model.
     * Peut mettre à jour s'il a la permission ET (est auteur OU est editor/admin)
     */
    public function update(User $user, Post $post): bool
    {
        return $user->can('posts.edit') && (
            $post->user_id === $user->id || $user->hasRole(['editor', 'admin'])
        );
    }

    /**
     * Determine whether the user can delete the model.
     * Peut supprimer s'il a la permission ET (est auteur OU editor/admin)
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->can('posts.delete') && (
            $post->user_id === $user->id || $user->hasRole(['editor', 'admin'])
        );
    }

    /**
     * Summary of publish  // Publier / dépublier : permission dédiée
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return bool
     */
    public function publish(User $user, Post $post)
    {
        return $user->can('posts.publish') && (
            $post->user_id === $user->id || $user->hasRole(['editor', 'admin'])
        );
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
