<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthenticationTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * Testing missing email address from login post
     * @return void
     */
    public function testRequestValidationForEmailFail()
    {
        $this->post("/api/login", [
            "email" => "",
            "password" => "123456",
        ]);

        $this->assertResponseStatus(422);
        $this->seeJsonContains(["The email field is required."]);

    }

    /**
     * Testing missing password address from login post
     * @return void
     */
    public function testRequestValidationForPasswordFail()
    {
        $this->post("/api/login", [
            "email" => "test@gmail.com",
            "password" => "",
        ]);

        $this->assertResponseStatus(422);
        $this->seeJsonContains(['The password field is required.']);
    }

    /**
     * Testing failed login
     * @return void
     */
    public function testRequestValidationForLoginFail()
    {
        $this->post("/api/login", [
            "email" => "test@gmail.com",
            "password" => "1234654",
        ]);

        $this->assertResponseStatus(401);
        $this->seeJsonContains(['User not found, please register.']);
    }

    /**
     * Testing successful login
     * @return void
     */
    public function testSuccessfulLogin()
    {
        $this->post('/api/register', [
            "full_name" => "Yoweli Kachala",
            "email" => "test@gmail.com",
            "password" => "1234654",
            "password_confirmation" => "1234654",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);

        $this->post("/api/login", [
            "email" => "test@gmail.com",
            "password" => "1234654",
        ]);

        $this->assertResponseStatus(200);
        $this->seeJsonContains(["success"]);
    }

}
