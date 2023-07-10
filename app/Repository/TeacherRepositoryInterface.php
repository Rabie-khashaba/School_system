<?php

namespace App\Repository;

interface TeacherRepositoryInterface{

    public function getAllTeachers();
    public function getSpecializations();
    public function getGender();

    public function StoreTeachers($request);

    public function getEditTeachers($id);
    public function updateTeachers($request);

    public function deleteTeacher($request);



}
