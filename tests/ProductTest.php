<?php

class ProductTest extends TestCase
{
    /**
     * /products [GET]
     */
    public function testShouldReturnAllProducts(){

        $mxi = $this->post("http://localhost/api/register", [
            "full_name" => "Yoweli Kachala",
            "email" => "yowelikachala@gmail.com",
            "password" => "27Nesleral?",
            "client_name" => "Our Solutions",
            "description" => "sample explanation"
        ]);

        $this->seeStatusCode(200);


    }

}
