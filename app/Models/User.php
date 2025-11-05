<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Os atributos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Os atributos que devem ser escondidos nas respostas JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
