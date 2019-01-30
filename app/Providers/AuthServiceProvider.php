<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Entities\{Post, User, Permission};

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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        /*$gate->define('update-post', function(User $user, Post $post){
            return $user->id == $post->user_id;
        });*/

        //pegar todas as permissões cadastradas
        $permissions = Permission::with('roles')->get();

        //loop para verificar quais permissões o usuário tem
        foreach ($permissions as $permission) {
            $gate->define($permission->name, function(User $user) use ($permission){
                return $user->hasPermission($permission);
            });
        } 

        //Método para verificar se o usuário logado é um administrador e naõ realizar o foreach
        $gate->before(function(User $user, $ability){

            if($user->hasAnyRoles('admin')){
                return true;
            }

        });
    }
}
