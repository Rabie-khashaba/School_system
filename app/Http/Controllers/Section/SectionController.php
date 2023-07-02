<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $Grades = Grade::with(['Sections'])->get();
        $listGrades = Grade::all();
        //return $Grades;
        return view('Sections.Sections',compact('Grades','listGrades'));
    }


    public function storeSections(Request $request){
        return $request;
    }
}
