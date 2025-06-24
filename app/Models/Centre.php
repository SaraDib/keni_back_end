<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    use HasFactory;

    protected $table = 'centres';
    protected $primaryKey = 'ID_Center';
    
    protected $fillable = [
        'ID_Entreprise',
        'Nom',
        'NomAR',
        'Adresse',
        'AdresseAR',
        'Telephone',
        'Fix',
        'Email',
        'Handicapes',
        'Positions'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
    
    public function horaires()
    {
        return $this->hasMany(Horaire::class, 'ID_Center', 'ID_Center');
    }
}