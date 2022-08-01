<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    /**
     * @param string $email
     * @param $value
     * @return User
     */
    public static function findOneBy(string $email, $value): User
    {
        return User::where($email, $value)->first();
    }
}
