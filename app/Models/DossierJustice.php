<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class DossierJustice extends Model
{
    use CrudTrait;
    use HasFactory;
    use RevisionableTrait;

    protected $fillable = [
        'code_affaire',
        'budget',
        'date_fin',
        'state',
        'secteur',
        'avocat_id',
        'user_id',
        'partie_adverse_id',
        'agence_id'
    ];

    protected $enums = [
        'state' => [
            'en préparation',
            "à l\'inspection de travail",
            'au tribunal',
            'à la cour',
            'à la cour suprême',
            'Gagné',
            'Perdu',
        ],
        'secteur' => [
            'Personnel',
            'Commerciale'
        ],
    ];

   
    public function identifiableName()
    {
        return $this->code_affaire;
    }

    public static function boot()
    {
        parent::boot();
    }
    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function avocat(){
        return $this->belongsTo(Avocat::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }

    public function partieAdverse()
    {
        return $this->belongsTo(PartieAdverse::class);
    }

    
}
