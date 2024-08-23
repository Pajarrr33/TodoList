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

    public function testLoginPageForMember()
    {
        $this->withSession([
        "user" => "Fajar"
        ])->get('/login')
        ->assertRedirect('/');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "Fajar"
        ])
        ->post('/login',[
            "user" => "Fajar",
            "password" => "secret"
        ])->assertRedirect("/");
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

    public function logOut()
    {
        $this->withSession([
            "user" => "Fajar"
        ])->$this->post('/logout')
        ->assertRedirect("/")
        ->assertSessionMissing("user");
        
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
        ->assertRedirect('/');
    }
}
