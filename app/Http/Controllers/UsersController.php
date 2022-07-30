<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 *  class UsersController
 */
class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function authenticate(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (Hash::check($request->input('password'), $user->password)) {

            $apikey = base64_encode(Str::random(40));

            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);;

            return response()->json(['status' => 'success', 'api_token' => $apikey]);

        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }
}

