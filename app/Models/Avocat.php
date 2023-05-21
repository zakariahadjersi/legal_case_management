<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avocat extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'nomprénom',
        'email',
        'telephone',
        'adresse'
    ];

    public function dossierJustices(){
        return $this->hasMany(DossierJustice::class);
    }
}
