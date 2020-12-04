<?php


namespace App\Repository;


use App\Entity\User;
use Core\Repository\ARepository;

class UserRepository extends ARepository
{
    protected function getEntity(): string
    {
        return User::class;
    }
}