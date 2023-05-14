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

    protected $enums = [
        'state' => [
            'started',
            'in_progress',
            'finished',
            'won',
            'lost',
        ],
    ];

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = $this->enums['state'][$value];
    }

    public function getStateAttribute($value)
    {
        return array_search($value, $this->enums['state']);
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
}
