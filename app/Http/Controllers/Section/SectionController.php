<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $Grades = Grade::with(['Sections'])->get();
        $listGrades = Grade::all();
        //return $Grades;
        return view('pages.Sections.Sections',compact('Grades','listGrades'));
    }


    public function storeSections(Request $request){
        //return $request;

        try {
            $my_sections = new Section();
            $my_sections->Name_Section = ['ar'=>$request->Name_Section_Ar,'en'=>$request->Name_Section_En];
            $my_sections->Grade_id = $request->Grade_id;
            $my_sections->Class_id = $request->Class_id;
            $my_sections->Status = 1;
            $my_sections->save();

            $notification = array(
                'message' => 'Data Has Been Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('sections.index')->with($notification);
        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
        }

    }

    public function updateSection(Request $request){
        //return $request;
        try {

            $my_sections = Section::findOrFail($request->id);

            if (isset($request->Status)){
                $my_sections-> Status = 1 ;
            }
            else{
                $my_sections-> Status = 0 ;
            }

            $my_sections->update([
                $my_sections->Name_Section = ['ar'=>$request->Name_Section_Ar,'en'=>$request->Name_Section_En],
                $my_sections->Grade_id = $request->Grade_id,
                $my_sections->Class_id = $request->Class_id,
                $my_sections->Status => $request->Status,
            ]);


            $notification = array(
                'message' => 'Data Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('sections.index')->with($notification);

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
            return redirect()->route('sections.index')->with($notification);


        }catch (\Exception $exception){
            return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);

        }
    }
}
