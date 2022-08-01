<?php

namespace App\Services;

use App\Http\Controllers\UserController;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientService
{

    /**
     * @param Request $request
     * @param int $userId
     * @return void
     */
    public static function create(Request $request, int $userId): void
    {
        Client::create([
            'name' => $request->input('client_name'),
            'description' => $request->input('description'),
            'user_id' => $userId
        ]);
    }

    /**
     * @param Request $request
     * @param UserController $instance
     * @return void
     * @throws ValidationException
     */
    public static function validateClientRequest(Request $request, UserController $instance): void
    {
        $instance->validate($request, [
            'full_name' => 'required',
            'client_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'description' => 'required'
        ]);
    }
}
