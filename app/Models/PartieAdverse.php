<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartieAdverse extends Model
{
    use CrudTrait;
    use HasFactory;

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

    public function dossierJustices()
    {
        return $this->hasMany(DossierJustice::class);
    }

    public function groupeTier(){
        return $this->belongsTo(GroupeTier::class);
    }
}
