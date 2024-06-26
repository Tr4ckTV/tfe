<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMembre extends Model
{
    use HasFactory;

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }

        public function users()
    {
        return $this->hasMany(User::class);
    }
}
