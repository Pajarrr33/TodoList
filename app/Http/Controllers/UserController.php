<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response ;

class UserController extends Controller
{

    private $userService;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()->view("User.login", ["title" => "Login"]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');

        // validate input
        if(empty($user) || empty($password)) {
            return response()->view("User.login", [
                "title" => "Login",
                "error" => "User or password required"
            ]);
        }

        if($this->userService->login($user,$password)) {
            $request->session()->put("user", $user);
            return redirect("/");
        }

        return response()->view("User.login", [
            "title" => "Login",
            "error" => "User or password not found"
        ]);

    }

    public function doLogout()
    {

    }
}
