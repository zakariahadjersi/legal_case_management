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
}
