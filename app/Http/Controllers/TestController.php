<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
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
     */
    public function test(Request $request)
    {
        //create a project
        // if project has been created
        // create models
        // create controllers
        // create repositories
        // create requests and validation
        // create middleware for users
        //

        foreach ($request->all('project') as $mean) {
            dd($mean);
        }

        return response()
            ->json(['name' => 'Abigail', 'state' => 'CA']);
    }
}
