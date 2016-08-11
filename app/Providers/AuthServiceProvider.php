<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //定義Admin使用者權限
        $gate->define('isSuperAdmin', function ($user) {
            return $user->leavl === 9;
        });
        //定義管理員權限
        $gate->define('isAdmin', function ($user) {
            return $user->leavl === 1;
        });
        //定義一般使用者權限
        $gate->define('isUser', function ($user) {
            return $user->leavl === 0;
        });
        //定義Demo使用者權限
        $gate->define('isDemoUser', function ($user) {
            return $user->leavl === -1;
        });
        //攔截權限檢查
        //設定admin
        $gate->before(function ($user, $ability) {
            if ($user->leavl === 9) {
                return true;
            }
        });
    }
}
