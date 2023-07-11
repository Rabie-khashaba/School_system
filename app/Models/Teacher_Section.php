<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_Section extends Model
{
    use HasFactory;

    protected $table = 'teachers_sections';
    protected $fillable =['Teacher_id', 'Section_id'];

}
