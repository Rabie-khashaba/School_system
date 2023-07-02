<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Classroom extends Model
{
    use HasTranslations; // spital translable

    protected $translatable = ['Name'];


    protected $table = 'Classrooms';
    protected $fillable = ['Name','Grade_id'];
    public $timestamps = true;

    public function Grades()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }

}
