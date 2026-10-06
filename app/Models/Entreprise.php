<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprises';
    protected $primaryKey = 'ID_Entreprise';
    protected $fillable = [
        'Nom',
        'Logo',
        'Telephone',
        'Whatsapp',
        'Email',
        'Adresse',
        'Facebook',
        'Instagram',
        'CouleurBackground',
        'ImageBackground'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function contactUs()
    {
        return $this->hasMany(ContactUs::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function faqs()
    {
        return $this->hasMany(FAQ::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function centres()
    {
        return $this->hasMany(Centre::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function offresEmploi()
    {
        return $this->hasMany(OffresEmploi::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}