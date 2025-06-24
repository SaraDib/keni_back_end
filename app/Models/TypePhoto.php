<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePhoto extends Model
{
    use HasFactory;

    protected $table = 'type_photos';
    protected $primaryKey = 'ID_Type_Photo';
    protected $fillable = [
        'Nom'
    ];

    public function rowServices()
    {
        return $this->hasMany(RowService::class, 'ID_Type_Photo', 'ID_Type_Photo');
    }
}