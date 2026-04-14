<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'matricula',
        'password',
        'status',
        'cargo_id',
        'cidade_id',
        'foto',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'equipe_user')
            ->withPivot('funcao_id')
            ->withTimestamps();
    }

    public function equipesOrientadas()
    {
        return $this->hasMany(Equipe::class, 'orientador_id');
    }

    public function equipeUsuarios()
    {
        return $this->hasMany(EquipeUser::class);
    }

    public function avaliacoesFeitas()
    {
        return $this->hasMany(Avaliacao::class, 'avaliador_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

}
