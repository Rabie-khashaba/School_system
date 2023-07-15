<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Student extends Model
{
    use HasFactory;

    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];


    public function grade(){
        return $this->belongsTo('App\Models\Grade','Grade_id');
    }
    public function gender(){
        return $this->belongsTo('App\Models\Gender' , 'gender_id');
    }

    public function classroom(){
        return $this->belongsTo('App\Models\Classroom' , 'Classroom_id');
    }
    public function section(){
        return $this->belongsTo('App\Models\Section' , 'section_id');
    }

    public function images():MorphMany
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }




}
