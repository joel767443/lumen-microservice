<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Testing missing full name address from register post
     * @return void
     */
    public function testRequestValidationFail()
    {
        $this->post("/api/register", [
            "full_name" => "",
            "email" => "test@gmail.com",
            "password" => "1234654",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);
        $this->assertResponseStatus(422);
        $this->seeJsonContains(["The full name field is required."]);

    }

    /**
     * test successful registrations
     * @return void
     */
    public function testSuccessfulRegistration()
    {
        $this->post("/api/register", [
            "full_name" => "test name",
            "email" => "test@gmail.com",
            "password" => "1234654",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);

        $this->assertResponseOk();
        $this->seeJsonContains(["success"]);
    }

}
