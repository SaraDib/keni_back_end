<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvantagesSociaux extends Model
{
    use HasFactory;

    protected $table = 'avantages_sociaux';

    protected $fillable = [
        'photo',
        'paragraphe',
    ];

    

    
}
