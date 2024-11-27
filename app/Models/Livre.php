<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $fillable = [
        'titre',
        'auteur',
        'annee_publication',
        'resume',
        'prix',
        'date_creation',
        'date_modification'
    ];

    protected $dates = [
        'date_creation',
        'date_modification'
    ];
}