<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donneur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ville_id',
        'groupe_sanguin_id',
        'telephone',
        'disponible',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function groupeSanguin()
    {
        return $this->belongsTo(GroupeSanguin::class, 'groupe_sanguin_id');
    }
}
