<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'type',
        'adresse',
        'telephone',
        'email'
    ];

    protected $enums = [
        'type' => [
            'Inspection De Travail',
            'Le Tribunal',
            'La Cour',
            'La Cour Supreme'
        ],
    ];


    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }
}
