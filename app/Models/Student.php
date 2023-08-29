<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class Student extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;


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

    public function Nationality(){
        return $this->belongsTo('App\Models\Nationalitie' , 'nationalitie_id');
    }

    public function myparent()
    {
        return $this->belongsTo('App\Models\MyParent', 'parent_id');
    }


    // image Morph (attachments)
    public function images():MorphMany
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function student_account()
    {
        return $this->hasMany('App\Models\StudentAccounts', 'student_id');

    }

    public function attendance()
    {
        return $this->hasMany('App\Models\Attendance', 'student_id');
    }


}
