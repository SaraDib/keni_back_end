<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';
    protected $primaryKey = 'ID_Rendez_Vous';
    
    protected $fillable = [
        'ID_Entreprise',
        'Nom',
        'Prenom',
        'Date_Naissance',
        'Tel',
        'Email',
        'Faire',
        'Type_recette',
        'nombre',
        'Ergotherapie',
        'Physiotherapie',
        'Remarque',
    ];

    protected $casts = [
        'Date_Naissance' => 'date',
        'nombre' => 'integer',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}