<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';
    protected $primaryKey = 'ID_Contact';
    
    protected $fillable = [
        'ID_Entreprise',
        'Nom',
        'Email',
        'Telephone',
        'Message',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}