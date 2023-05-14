<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'nom'
    ];

    public function audience()
    {
        return $this->belongsTo(Audience::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
