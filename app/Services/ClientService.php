<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\Request;

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
}
