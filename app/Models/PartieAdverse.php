<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartieAdverse extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prénom',
        'email',
        'telephone',
        'adresse'
    ];

    public function dossierJustices()
    {
        return $this->hasMany(DossierJustice::class);
    }

    public function contratNature(){
        return $this->belongsTo(ContratNature::class);
    }

    public function groupeTier(){
        return $this->belongsTo(GroupeTier::class);
    }
}
