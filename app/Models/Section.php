<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = ['Name_Section' , 'Status', 'Grade_id','Class_id' , 'created_at','updated_at'];
    public $timestamps = true;

}
