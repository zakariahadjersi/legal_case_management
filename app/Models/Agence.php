<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'adresse',
        'telephone',
        'email'
    ];

    public function dossierJustices()
    {
        return $this->hasMany(DossierJustice::class);
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }
}
