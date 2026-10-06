<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

/**
 * Aturan akses artikel:
 * - admin  : boleh semua
 * - editor : boleh buat artikel, tapi cuma boleh edit/hapus artikel miliknya sendiri
 * - user   : cuma bisa baca artikel yang sudah publish
 */
class PostPolicy
{
    /**
     * Halaman kelola artikel
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN, User::ROLE_EDITOR);
    }

    /**
     * Lihat detail artikel. Draft cuma bisa dilihat admin dan penulisnya.
     */
    public function view(?User $user, Post $post): bool
    {
        if ($post->is_published) {
            return true;
        }

        return $user !== null && ($user->isAdmin() || $user->id === $post->user_id);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(User::ROLE_ADMIN, User::ROLE_EDITOR);
    }

    public function update(User $user, Post $post): bool
    {
        return $user->isAdmin()
            || ($user->role === User::ROLE_EDITOR && $user->id === $post->user_id);
    }

    public function delete(User $user, Post $post): bool
    {
        // aturannya sama dengan update
        return $this->update($user, $post);
    }
}
