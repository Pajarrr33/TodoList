<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
   private UserService $userService;

   protected function setUp(): void
   {
     parent::setUp();

     $this->userService = $this->app->make(UserService::class);
   }

   
   public function testLoginSucces()
   {
        self::assertTrue($this->userService->login("Fajar","secret"));
   }

   public function testLoginFailed()
   {
     self::assertFalse($this->userService->login("secret","Fajar"));
   }

   public function testLoginWrongPassword()
   {
    self::assertFalse($this->userService->login("Fajar","rahasia"));
   }
}
