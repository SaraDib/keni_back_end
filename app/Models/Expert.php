<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $table = 'experts';
    protected $primaryKey = 'ID_Expert';

    protected $fillable = [
        'VideoURL',
        'ImagePath',
        'TitleFR',
        'TitleAR',
        'DescriptionFR',
        'DescriptionAR',
        'Etat'
    ];
}