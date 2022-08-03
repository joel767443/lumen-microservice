<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * testing if the user is allowed to create a project
     * @return void
     */
    public function testCreateProjectByUnAuthorisedUser()
    {
        $this->post('/api/register', [
            "full_name" => "Yoweli Kachala",
            "email" => "test@gmail.com",
            "password" => "1234654",
            "password_confirmation" => "1234654",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);

        $this->post('/api/project', [
            "name" => 'test project'
        ]);


        $this->seeJsonContains(["Unauthorized"]);
    }

    /**
     * testing if the user is allowed to create a project
     * @return void
     */
    public function testCreateProjectByAuthorisedUser()
    {
        $this->post('/api/register', [
            "full_name" => "Yoweli Kachala",
            "email" => "test@gmail.com",
            "password" => "1234654",
            "password_confirmation" => "1234654",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);

        $this->call(
            "POST", '/api/project', [
            'name' => 'test projects'], [], [],
            $this->transformHeadersToServerVars([
                'Authorization' => 'Bearer ' . json_decode($this->response->content())->data->api_token
            ]),
            ''
        );

        $this->seeJsonContains(["success"]);
    }


}
