<?php

namespace App\Http\Controllers;

use App\Models\Project;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        return response()->json($request->all());
        $project = Project::create($request->all());
        return response()->json([
            'status' => 200,
            'project' => $project
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getProject($id): JsonResponse
    {
        return response()->json(Project::find($id));
    }
}
