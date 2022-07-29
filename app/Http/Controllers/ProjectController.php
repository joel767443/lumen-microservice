<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $project = new Project();

        return response()->json([
            'status' => 200,
            'project' => $project
        ]);
    }
}
