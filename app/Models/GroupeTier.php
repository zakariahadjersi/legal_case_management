<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupeTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutelle',
        'famille',
        'groupe',
        'secteur'
    ];

    public function partieAdverses(){
        return $this->belongsToMany(PartieAdverse::class);
    }
}
