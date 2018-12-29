<?php


namespace App\Services\Auth;


use App\Entity\User;
use App\Repository\User\UserRepository;

class Auth
{
    private static $user;

    public static function getUser(): User
    {
        if(is_null(static::$user)) {
            /* @var UserRepository $repository */
            $repository = app()->make(UserRepository::class);

            static::$user = $repository->findById(1);
        }

        return static::$user;
    }
}