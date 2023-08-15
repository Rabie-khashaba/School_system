<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class online_classe extends Model
{

    use HasFactory;

    protected $table = 'online_classes';
    //public $fillable= ['integration','Grade_id','Classroom_id','section_id','created_by','meeting_id','topic','start_at','duration','password','start_url','join_url'];

    protected $guarded = [];
    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }


    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
