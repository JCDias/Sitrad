<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Entities\{Permission, Role};

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','cpf','matricula', 'status', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFormattedCpfAttribute(){
        $cpf = $this->attributes['cpf'];
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 7, 3) . '-' .substr($cpf, -2);
    }

    //ORM database atributos
    public $timestamps = true;

    //Definindo relacionamentos
    public function solicitacao(){
        return $this->hasMany(Solicitacao::class,'id','user_id');
    }

    public function cursos(){
        return $this->belongsToMany(Cursos::class);
    }

    //Retornar todas as funções(papéis) que estão atribuidas ao usuário logado
    public function roles(){
        return $this->belongsToMany(Role::class);
    }


    //Recuperando todas as funções(papéis) atribuidas a permissão que esta sendo passada
    public function hasPermission(Permission $permission){

        return $this->hasAnyRoles($permission->roles);

    }

    //Verificar quais as funções que estão ligadas ao usuário logado
    //E vê se tem a função(papel) recebida do método hasPermission atribuida a ele
    public function hasAnyRoles($roles){

        //Verifica se existe mais de um papel vinculado ao usuário logado e faz loop para verificar todas as permissões

        //Verificar quantas vezes o usuário logado esta vinculado ao papel
        if (is_array($roles) || is_object($roles)){
            return !! $roles->intersect($this->roles)->count();
        }

        //Verificando se nas funções(papéis) vinculados ao usuário tem uma com o nome passado na variável $roles
        return $this->roles->contains('name', $roles);

    }

    public $rules = [ 
        'name'      => 'required|string|min:3|max:100',
        'email'     => 'required|string|email|max:80|unique:users',
        'username'  => 'required|string|min:4|max:100|unique:users',
        'cpf'       => 'required|cpf|numeric|unique:users',
        'matricula' => 'required|numeric|min:6|unique:users',
        'password'  => 'required|string|min:6|confirmed',
    ];

    public $rulesUpdate = [ 
        'name'      => 'required|string|min:3|max:100',
        'email'     => 'required|string|email|max:80',
        'username'  => 'required|string|min:4|max:100',
        'password'  => 'string|min:6|confirmed',
    ];
     public $rulesUpdateSemSenha = [ 
        'name'      => 'required|string|min:3|max:100',
        'email'     => 'required|string|email|max:80',
        'username'  => 'required|string|min:4|max:100',
    ];

}
