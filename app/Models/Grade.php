<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations; //

class Grade extends Model
{
    use HasTranslations; // spital translable
    public $translatable = ['name']; //


    protected $table = 'Grades';

    protected $fillable =['name', 'notes','created_at' , 'updated_at'];
    public $timestamps = true;



    public function Sections(){
        return $this->hasMany('App\Models\Section','Grade_id');
    }

}
