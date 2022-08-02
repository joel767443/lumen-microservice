<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    /**
     * @param string $field
     * @param $value
     * @return User
     */
    public static function findOneBy(string $field, $value): ?User
    {
        return User::where($field, $value)->first();
    }
}
