<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
             ->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $this->post('/login',[
            "user" => "Fajar",
            "password" => "secret"
        ])->assertRedirect("/")
          ->assertSessionHas("user","Fajar");
    }

    public function testLoginValidationError()
    {
        $this->post('/login',[])->assertSeeText("User or password required");
    }

    public function testLoginFailed()
    {
        $this->post('/login',[
            "user" => "salah",
            "password" => "salah",
        ])->assertSeeText("User or password not found");
    }
}
