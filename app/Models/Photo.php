<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'photos';
    protected $primaryKey = 'ID_Photo';
    protected $fillable = [
        'ID_Row',
        'Photo'
    ];

    public function rowService()
    {
        return $this->belongsTo(RowService::class, 'ID_Row', 'ID_Row');
    }
}