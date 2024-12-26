<?php

namespace App\Sharp;

use Code16\Sharp\Auth\SharpAuthenticationCheckHandler;

class SharpCheckHandler implements SharpAuthenticationCheckHandler
{
    public function check($user): bool
    {
        return $user['is_super_user'];
    }
}
