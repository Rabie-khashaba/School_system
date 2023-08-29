<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class MyParent extends Authenticatable
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['Name_Father','Job_Father','Name_Mother','Job_Mother'];

    protected $table = 'my_parents';
    protected $guarded =[];


}
