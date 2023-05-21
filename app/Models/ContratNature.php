<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratNature extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitulle'
    ];

    public function partieAdverses(){
        return $this->hasMany(PartieAdverse::class);
    }
}
