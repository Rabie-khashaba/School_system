<?php

namespace App\Repository;

interface StudentGraduationRepositoryInterface
{

    public function create();
    public function index();

    public function SoftDelete($request);
    public function ReturnData($request);
    public function destroy($request);
    public function GraduateStudent($request);
}
