<?php

namespace App\Services;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{

    /**
     * @param Request $request
     * @param string $token
     * @return User
     */
    public static function create(Request $request, string $token): User
    {
        return User::create([
            'name' => $request->input('full_name'),
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

    /**
     * @param Request $request
     * @param UserController $instance
     * @return void
     * @throws ValidationException
     */
    public static function validateUserRequest(Request $request, UserController $instance): void
    {
        $instance->validate($request, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);
    }
}
