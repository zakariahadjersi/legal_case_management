<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avocat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prénom',
        'email',
        'telephone',
        'adresse'
    ];

    public function dossierjustices(){
        return $this->hasMany(DossierJustice::class);
    }
}
