<?php

namespace App\Repository;

interface StudentRepositoryInterface{

    public function createStudent();
    public function Get_classrooms($id);
    public function Get_Sections($id);

    public function Store_Student($request);
}
