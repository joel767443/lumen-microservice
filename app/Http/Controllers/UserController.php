<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\ClientService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 *  class UserController
 */
class UserController extends Controller
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

        $user = UserRepository::findOneBy('email', $request->input('email'));

        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = UserService::addTokenIfNotExist($request, $user);
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
            $userId = UserService::create($request, $token);
            ClientService::create($request, $userId);
            DB::commit();
            return response()->json(['status' => 'success', 'api_token' => $token]);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 401);

        }
    }

}

