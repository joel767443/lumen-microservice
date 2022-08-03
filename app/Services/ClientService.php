<?php

namespace App\Services;

use App\Http\Controllers\UserController;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
            'password' => 'required|min:6|confirmed',
            'description' => 'required'
        ]);
    }

    /**
     * @param string $token
     * @param User $user
     * @return JsonResponse
     */
    public static function getClientJsonResponse(string $token, User $user): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'api_token' => $token,
                'client' => [
                    'full_name' => $user->name,
                    'customer_name' => $user->client->name,
                    'email' => $user->email,
                    'description' => $user->client->description,
                ]
            ]
        ]);
    }
}
