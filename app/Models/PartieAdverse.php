<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartieAdverse extends Model
{
    use CrudTrait;
    use HasFactory;
    use RevisionableTrait;

    protected $fillable = [
        'nomprénom',
        'email',
        'telephone',
        'adresse',
        'naturecontractant',
        'tutelletiers',
        'familletiers',
        'groupetiers',
        'secteurtiers'
    ];

    protected $enums = [
        'naturecontractant' => [
            'Administration',
            'Collectivités locales',
            'Entreprise public',
            'Entreprise privée',
            'Entreprise étrangère'
        ],
        'secteurtiers'      => [
            'Privé','Public'
        ]
    ];

    public function identifiableName()
    {
        return $this->nomprénom;
    }

    public static function boot()
    {
        parent::boot();
    }

    public function dossierJustices()
    {
        return $this->hasMany(DossierJustice::class);
    }

    public function groupeTier(){
        return $this->belongsTo(GroupeTier::class);
    }
}
