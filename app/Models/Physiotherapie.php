<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physiotherapie extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'physiotherapie';

    protected $fillable = ['nom'];
}
