<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSections;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Teacher_Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function index(){
        $Grades = Grade::with(['Sections'])->get();
        $listGrades = Grade::all();
        //return $Grades;
        $teachers = Teacher::all();

        return view('pages.Sections.Sections',compact('Grades','listGrades','teachers'));
    }


    public function storeSections(Request $request){
       // return $request;

        DB::beginTransaction();
        try {
            $my_sections = new Section();
            $my_sections->Name_Section = ['ar'=>$request->Name_Section_Ar,'en'=>$request->Name_Section_En];
            $my_sections->Grade_id = $request->Grade_id;
            $my_sections->Class_id = $request->Class_id;
            $my_sections->Status = 1;
            $my_sections->save();

            //Add id in pivot table
            $my_sections->teachers()->attach($request->teacher_id); // get id of teacher


            DB::commit();
            $notification = array(
                'message' => 'Data Has Been Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Sections.index')->with($notification);

        }catch (\Exception $exception){
            DB::rollback();
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
        }

    }

    public function updateSection(StoreSections $request){
           //return $request;
        try {

            $validated = $request->validated();
            $Sections = Section::findOrFail($request->id);

            $Sections->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $Sections->Grade_id = $request->Grade_id;
            $Sections->Class_id = $request->Class_id;

            //Status Update
            if(isset($request->Status)) {
                $Sections->Status = 1;
            } else {
                $Sections->Status = 0;
            }


            // update pivot tABLE
            if (isset($request->teacher_id)) {
                $Sections->teachers()->sync($request->teacher_id);  // if select one teacher
            }else {
                $Sections->teachers()->sync(array());  // if select more than one teacher
            }


            $Sections->save();

            $notification = array(
                'message' => 'Data Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Sections.index')->with($notification);

        }catch (\Exception $exception){
                return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
            }
    }


    public function getClasses($id){
        //return $id;
        $list_classes = Classroom::where('Grade_id',$id)->pluck('Name','id');
        return $list_classes;

    }

    public function destroySection(Request $request){
        try {
            $my_section = Section::findOrFail($request->id);
            $my_section->delete();

            $notification = array(
                'message' => 'Data Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->route('Sections.index')->with($notification);


        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);

        }
    }
}
