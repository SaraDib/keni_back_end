<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';
    protected $primaryKey = 'ID_FAQ';
    
    protected $fillable = [
        'ID_Entreprise',
        'Question',
        'Reponse',
        'QuestionAR',
        'ReponseAR',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }
}