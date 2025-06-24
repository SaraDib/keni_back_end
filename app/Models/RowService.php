<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowService extends Model
{
    use HasFactory;

    protected $table = 'row_services';
    protected $primaryKey = 'ID_Row';
    protected $fillable = [
        'ID_Service',
        'ID_Type_Photo',
        'Text',
        'TextAR',
        'Classement'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'ID_Service', 'ID_Service');
    }

    public function typePhoto()
    {
        return $this->belongsTo(TypePhoto::class, 'ID_Type_Photo', 'ID_Type_Photo');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'ID_Row', 'ID_Row');
    }
}