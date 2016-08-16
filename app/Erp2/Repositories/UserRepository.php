<?php
namespace Erp\Repositories;

use App\Repositories\BasicRepository;
use App\User;

class UserRepository extends BasicRepository
{
    private $user;

    public function __contruct(User $user)
    {
        $this->user = $user;
    }
}
