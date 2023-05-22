<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'date',
        'resultat'
    ];

    public function dossierJustice()
    {
        return $this->belongsTo(DossierJustice::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
