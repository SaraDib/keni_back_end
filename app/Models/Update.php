<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $table = 'updates';
    protected $primaryKey = 'ID_Updates'; 
    protected $fillable = ['image_path', 'title_fr', 'title_ar', 'description_fr', 'description_ar', 'active'];
    protected $casts = [
        'active' => 'boolean',
    ];
}