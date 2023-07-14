<?php

namespace App\Repository;

interface StudentRepositoryInterface{

    public function Get_Student();

    public function createStudent();
    public function Get_classrooms($id);
    public function Get_Sections($id);

    public function Store_Student($request);

    public function Edit_Student($id);
    public function Update_Student($request);

    public function delete_student($request);
}
