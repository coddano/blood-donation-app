<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function donneurs()
    {
        return $this->hasMany(Donneur::class);
    }

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }
}
