<?php

namespace App\Http\Controllers\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use App\Repository\TeacherRepositoryInterface;
use Illuminate\View\View;

class TeacherController extends Controller
{

    protected $Teacher;
    public function __construct(TeacherRepositoryInterface $Teacher)
    {
        $this->Teacher = $Teacher;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers=  $this->Teacher->getAllTeachers();
        return view('pages.Teachers.Teachers',compact('teachers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = $this->Teacher->getSpecializations();
        $genders = $this->Teacher->getGender();

        return view('pages.Teachers.create',compact('specializations','genders'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return $this->Teacher->StoreTeachers($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $specializations = $this->Teacher->getSpecializations();
        $genders = $this->Teacher->getGender();
        $Teachers = $this->Teacher->getEditTeachers($id);
        return view('pages.Teachers.Edit',compact('Teachers','specializations','genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->Teacher->updateTeachers($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->Teacher->deleteTeacher($request);
    }
}
