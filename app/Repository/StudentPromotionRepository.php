<?php

namespace App\Repository;

use App\Models\Grade;
use App\Models\Promotion;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentPromotionRepository implements StudentPromotionRepositoryInterface
{
    public function index(){
        $Grades = Grade::all();
        return view('pages.Students.promotion.index',compact('Grades'));
    }

    public function store($request)
    {

        //return $request;
        DB::beginTransaction();

        try {
            //get Students in old grades equals  $request->Grade_id , Classroom_id ,section_id
            $students = student::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->where('academic_year',$request->academic_year)->get();
            //return $students;
            if($students->count() < 1){
                return redirect()->back()->with('error_promotions', __('Students_trans.Not Data In student Table'));
            }

            // update in table student
            foreach ($students as $student){

                $ids = explode(',',$student->id); // get ids of students in array
                student::whereIn('id', $ids)
                    ->update([
                        'Grade_id'=>$request->Grade_id_new,
                        'Classroom_id'=>$request->Classroom_id_new,
                        'section_id'=>$request->section_id_new,
                        'academic_year'=>$request->academic_year_new,
                    ]);

                // insert data in promotions table  (not duplicated if same data)
                Promotion::updateOrCreate([
                    'student_id'=>$student->id,
                    'from_grade'=>$request->Grade_id,
                    'from_Classroom'=>$request->Classroom_id,
                    'from_section'=>$request->section_id,
                    'to_grade'=>$request->Grade_id_new,
                    'to_Classroom'=>$request->Classroom_id_new,
                    'to_section'=>$request->section_id_new,
                    'academic_year'=>$request->academic_year,
                    'academic_year_new'=>$request->academic_year_new,
                ]);


            }
            DB::commit();
            $notification = array(
                'message' => 'Students promotion successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Promotion.index')->with($notification);


        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
