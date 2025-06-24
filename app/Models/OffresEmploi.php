<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffresEmploi extends Model
{
    use HasFactory;

    protected $table = 'offres_emploi';
    protected $primaryKey = 'ID_Offres_Emploi';
    
    protected $fillable = [
        'ID_Entreprise',
        'Salutation',
        'Nom',
        'Rue',
        'Code_Postal',
        'Ville',
        'Email',
        'Telephone',
        'Profession',
        'lettre',
        'CV',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}