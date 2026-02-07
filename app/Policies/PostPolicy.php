<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Kullanıcının bu yazıyı güncelleyip güncelleyemeyeceğini belirle
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Kullanıcının bu yazıyı silebilip silemeyeceğini belirle
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Kullanıcının yazı oluşturabilip oluşturamayacağını belirle
     */
    public function create(User $user): bool
    {
        return true;
    }
}
