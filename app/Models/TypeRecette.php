<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRecette extends Model
{
    use HasFactory;
    protected $table = 'types_recette';

    protected $fillable = ['nom'];
}
