<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function createModels($projectId)
    {
        $project = Project::find($projectId);

    }

    /**
     * @param Request $request
     * @return array|string|string[]
     */
    public function models(Request $request) {
        $clasName = ucfirst($request->input("model"));
        $stub = $this->getStub('model');
        $contents = $this->replaceText($stub, $clasName);

        $this->put(base_path() . '/app/Models/' . $clasName . '.php', $contents);
    }

    /**
     * @param $stub
     * @return string
     */
    private function getStub($stub)
    {
        return file_get_contents(
            base_path() .
            "/app/stubs/" .
            $stub .
            ".stub"
        );
    }

    private function replaceText(string $stub, string $name)
    {
        $searches = [
            ['{{ class }}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                $name,
                $stub
            );
        }

        return $stub;
    }

    /**
     * Write the contents of a file.
     *
     * @param string $path
     * @param string $contents
     * @return int|bool
     */
    public function put(string $path, string $contents)
    {
        return file_put_contents($path, $contents);
    }
}
