<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory;
    use HasTranslations; // spital translable
    public $translatable = ['Name_Section']; //


    protected $table = 'sections';
    protected $fillable = ['Name_Section' , 'Status', 'Grade_id','Class_id' , 'created_at','updated_at'];
    public $timestamps = true;

    // علاقة بين الاقسام والصفوف لجلب اسم الصف في جدول الاقسام

    public function My_classs()
    {
        return $this->belongsTo('App\Models\Classroom', 'Class_id');
    }

    public function teachers(){
        return $this->belongsToMany('App\Models\Teacher','teachers_sections');
    }

    public function Grades(){
        return $this->belongsTo('App\Models\Grade','Grade_id');
    }




}
