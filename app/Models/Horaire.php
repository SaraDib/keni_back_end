<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;

    protected $table = 'horaires';
    protected $primaryKey = 'ID_Horaire';
    
    protected $fillable = [
        'ID_Center',
        'Day_Start',
        'Day_Start_AR',
        'Time_Start',
        'Time_End',
        'isClosed',
    ];

    public function centre()
    {
        return $this->belongsTo(Centre::class, 'ID_Center', 'ID_Center');
    }
}