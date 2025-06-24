<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $primaryKey = 'ID_Service';
    protected $fillable = [
        'ID_Entreprise',
        'Nom',
        'NomAR',
        'Descriptions',
        'DescriptionsAR',
        'Photos',
        'Etat'
    ];

    protected $casts = [
        'Etat' => 'boolean',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'ID_Entreprise', 'ID_Entreprise');
    }

    public function rowServices()
    {
        return $this->hasMany(RowService::class, 'ID_Service', 'ID_Service');
    }
}