<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom'
    ];

    
    public function agences()
    {
        return $this->hasMany(Agence::class);
    }
}
