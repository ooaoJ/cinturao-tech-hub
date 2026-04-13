<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $matricula)
 * @property mixed $cargo_id
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

//    public function cargo()
//    {
//        return $this->belongsTo(Cargo::class);
//    }
//
//    public function cidade()
//    {
//        return $this->belongsTo(Cidade::class);
//    }
}
