<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_bloods extends Model
{
    use HasFactory;

    protected $table = 'type_bloods';
    protected $fillable = ["Name"];
}
