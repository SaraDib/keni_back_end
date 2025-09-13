<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
     use HasFactory;

    protected $table = 'slider_images'; // ou le nom de ta table
    protected $primaryKey = 'ID_Image'; // si tu as utilisé ID_Image
    protected $fillable = [
        'Path'
    ];
}
