<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $table = 'tokens_acceso_personal';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre',
        'token',
        'habilidades',
        'ultimo_uso_en',
        'expira_en',
    ];

    protected $casts = [
        'habilidades' => 'json',
        'ultimo_uso_en' => 'datetime',
        'expira_en' => 'datetime',
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
    ];
}