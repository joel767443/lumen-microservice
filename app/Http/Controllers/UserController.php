<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        UserService::validateUserRequest($request, $this);
        $user = UserRepository::findOneBy('email', $request->input('email'));

        if (!$user) {
            return response()->json(['status' => 'fail', 'message' => 'User not found, please register.'], 400);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = UserService::addTokenIfNotExist($request, $user);
            return response()->json(['status' => 'success', 'api_token' => $apikey], 200);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Email or Password does not match our records.'], 401);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        ClientService::validateClientRequest($request, $this);

        if ($user = User::exists($request->input('email'))) {
            return response()->json(['status' => 'success', 'api_token' => $user->api_token], 200);
        }

        DB::beginTransaction();

        try {
            $token = base64_encode(Str::random(40));
            $userId = UserService::create($request, $token);
            ClientService::create($request, $userId);
            DB::commit();
            return response()->json(['status' => 'success', 'api_token' => $token], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'fail', 'message' => $e->getMessage()], 300);
        }
    }

}

