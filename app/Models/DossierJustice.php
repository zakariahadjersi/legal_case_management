<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierJustice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_affaire',
        'budget',
        'date_fin'
    ];
}
