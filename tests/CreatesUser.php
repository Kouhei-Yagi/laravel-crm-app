<?php

namespace Tests;

use App\Models\User;

trait CreatesUser
{
    protected function loginUser($attributes = [])
    {
        $user = User::factory()->create($attributes);
        $this->actingAs($user);
        return $user;
    }
}
