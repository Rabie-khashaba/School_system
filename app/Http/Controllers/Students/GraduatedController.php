<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Repository\StudentGraduationRepositoryInterface;
use Illuminate\Http\Request;

class GraduatedController extends Controller
{

    protected $Graduated;

    public function __construct(StudentGraduationRepositoryInterface $Graduated)
    {
        $this->Graduated = $Graduated;
    }

    public function index()
    {
        return $this->Graduated->index();
    }


    public function create()
    {
        return $this->Graduated->create();
    }


    public function store(Request $request)
    {
        return $this->Graduated->SoftDelete($request);
    }

    public function GraduateStudent(Request $request)
    {
        return $this->Graduated->GraduateStudent($request);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request)
    {
        return $this->Graduated->ReturnData($request);
    }


    public function destroy(Request $request)
    {
        return $this->Graduated->destroy($request);
    }
}
