<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'equipes';
    protected $primaryKey = 'ID_Equipe';
    
    protected $fillable = [
        'ID_Entreprise',
        'Nom',
        'NomAR',
        'Image',
        'Profession',
        'Description',
        'ProfessionAR',
        'DescriptionAR',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}