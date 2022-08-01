<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * @param Request $request
     * @param string $token
     * @return integer
     */
    public static function create(Request $request, string $token): int
    {
        return User::insertGetId([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'api_token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @param User $instance
     * @return string
     */
    public static function addTokenIfNotExist(Request $request, User $instance): string
    {
        if ($instance->api_token == "") {
            $apikey = base64_encode(Str::random(40));
            UserRepository::findOneBy('email', $request->input('email'))->update(['api_token' => "$apikey"]);
        }
        return $instance->api_token;
    }
}
