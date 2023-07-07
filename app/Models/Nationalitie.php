<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Nationalitie extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = 'nationalities';
    public $translatable = ['Name']; //

    protected $fillable = ['Name'];
    //or
    //protected $guarded=[];  // write instead of $fillable , without fields
}
