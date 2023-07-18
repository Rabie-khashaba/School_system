<?php

namespace App\Repository;

interface StudentRepositoryInterface{

    public function Get_Student();

    public function createStudent();
    public function Get_classrooms($id);
    public function Get_Sections($id);

    public function Store_Student($request);

    public function Edit_Student($id);
    public function show_Student($id);
    public function Upload_attachment($request);
    public function Download_attachment($studentsname, $filename);
    public function Delete_attachment($request);

    public function Update_Student($request);

    public function delete_student($request);
}
