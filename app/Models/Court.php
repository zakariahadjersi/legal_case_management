<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'adresse',
        'telephone',
        'email'
    ];

    protected $enums = [
        'type' => [
            'inspection de travail',
            'le tribunal',
            'la cour',
            'la cour supreme'
        ],
    ];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $this->enums['type'][$value];
    }

    public function getTypeAttribute($value)
    {
        return array_search($value, $this->enums['type']);
    }

    public function audiences()
    {
        return $this->hasMany(Audience::class);
    }
}
