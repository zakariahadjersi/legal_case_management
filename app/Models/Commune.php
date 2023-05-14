<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom'
    ];

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function agence()
    {
        return $this->hasOne(Agence::class);
    }
}
