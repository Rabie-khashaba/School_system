<?php


namespace App\Repository;
use App\Models\Teacher;

Class TeacherRepository implements TeacherRepositoryInterface{
    public function getAllTeachers()
    {
        return  Teacher::all();
    }
}
