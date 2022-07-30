<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        dd(User::all());
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = $this->addTokenIfNotExist($user, $request);
            return response()->json(['status' => 'success', 'api_token' => $apikey]);
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {

        DB::beginTransaction();

        try {

            $token = base64_encode(Str::random(40));

            $userId = User::insertGetId([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'api_token' => $token
            ]);

            Client::create([
                'name' => $request->input('client_name'),
                'description' => $request->input('description'),
                'user_id' => $userId
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'api_token' => $token]);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 401);

        }
    }

    /**
     * @param User $user
     * @param Request $request
     * @return string
     */
    public function addTokenIfNotExist(User $user, Request $request): string
    {
        if ($user->api_token == "") {
            $apikey = base64_encode(Str::random(40));
            User::where('email', $request->input('email'))->update(['api_token' => "$apikey"]);
        }
        return $user->api_token;
    }
}

