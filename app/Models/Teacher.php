<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;

class Teacher extends Authenticatable
{
    use HasFactory;
    use HasTranslations;

    public $table = 'teachers';
    public $translatable = ['Name'];
    protected $guarded=[];


    // علاقة بين المعلمين والتخصصات لجلب اسم التخصص
    public function specializations()
    {
        return $this->belongsTo('App\Models\Specialization', 'Specialization_id');
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم
    public function genders()
    {
        return $this->belongsTo('App\Models\Gender', 'Gender_id');
    }

// علاقة المعلمين مع الاقسام
    public function Sections()
    {
        return $this->belongsToMany('App\Models\Section','teachers_sections');
    }

    public function Grades()
    {
        return $this->belongsTo('App\Models\Grade','Grade_id');
    }



}
