<?php 

namespace App\Services\Implementation;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users = [
        "Fajar" => "secret"
    ];

    function login(string $user, string $password): bool
    {
        if(!isset($this->users[$user])) {
            return false;
        } 

        $corretPassword = $this->users[$user];
        return $password == $corretPassword;
    }
}