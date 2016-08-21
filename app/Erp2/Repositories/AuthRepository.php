<?php
namespace Erp\Repositories;

use App;
use Erp\Auth;
use App\Repositories\BasicRepository;

class AuthRepository extends BasicRepository
{
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getAuthsWithOutSuperAdmin()
    {
        return $this->auth->where('level', '!=', '9')->get();
    }
}