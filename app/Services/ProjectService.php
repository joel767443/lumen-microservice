<?php

namespace App\Services;

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProjectService
{

    /**
     * @param Request $request
     * @return void
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public static function create(Request $request): void
    {
        Project::create([
            'name' => $request->input('name'),
            'client_id' => Auth::user()->client->id
        ]);
    }

    /**
     * @param Request $request
     * @param ProjectController $instance
     * @return void
     * @throws ValidationException
     */
    public static function validateProjectRequest(Request $request, ProjectController $instance)
    {
        $instance->validate($request, [
            'name' => 'required',
        ]);
    }
}
