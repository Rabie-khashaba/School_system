<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Student;

class StudentGraduationRepository implements StudentGraduationRepositoryInterface
{

    public function index()
    {
        $students = Student::onlyTrashed()->get();  // where delete at ---> not equal null
        return view('pages.Students.Graduated.index',compact('students'));
    }
    public function create(){
        $Grades = Grade::all();
        return view('pages.Students.Graduated.create',compact('Grades'));
    }

    public function SoftDelete($request)
    {
        $students = student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

        if($students->count() < 1){
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }

        foreach ($students as $student){
            $ids = explode(',',$student->id);
            student::whereIn('id', $ids)->Delete();
        }

        $notification = array(
            'message' => 'Graduated Student successfully',
            'alert-type'=> 'success',
        );
        return redirect()->route('Graduated.index')->with($notification);

    }


    public function ReturnData($request)
    {
        student::onlyTrashed()->where('id', $request->id)->first()->restore();
        $notification = array(
            'message' => 'Graduated Student Returned successfully',
            'alert-type'=> 'success',
        );
        return redirect()->route('Graduated.index')->with($notification);
    }

    public function destroy($request)
    {
        student::onlyTrashed()->where('id', $request->id)->first()->forceDelete();
        $notification = array(
            'message' => 'Graduated Student Deleted successfully',
            'alert-type'=> 'success',
        );
        return redirect()->route('Graduated.index')->with($notification);

    }



    //GraduateStudent

    public function GraduateStudent($request){

        Student::findOrFail($request->id)->first()->delete();
        student::onlyTrashed()->where('id', $request->id)->first()->Delete();
        $notification = array(
            'message' => 'Graduated Student Deleted successfully',
            'alert-type'=> 'success',
        );
        return redirect()->route('Students.index')->with($notification);
    }

}
