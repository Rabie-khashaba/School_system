<?php

namespace App\Repository;

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\MyParent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Type_bloods;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements StudentRepositoryInterface{


    public function Get_Student(){
        $students = Student::all();
        return view('pages.Students.index' , compact('students'));
    }

    public function createStudent(){
        $data['Grades'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_bloods::all();
        return view('pages.Students.add',$data);
    }


    public function Store_Student($request){

        try {
            $students = new Student();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();
            $notification = array(
                'message' => 'Data Has Been Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Students.index')->with($notification);
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    public function Get_classrooms($id){

        $list_classes = Classroom::where("Grade_id", $id)->pluck("Name", "id");
        return $list_classes;

    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = Section::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }



    //edit
    public function Edit_Student($id)
    {
        $data['Grades'] = Grade::all();
        $data['parents'] = MyParent::all();
        $data['Genders'] = Gender::all();
        $data['nationals'] = Nationalitie::all();
        $data['bloods'] = Type_bloods::all();
        $Students =  Student::findOrFail($id);
        return view('pages.Students.edit',$data,compact('Students'));
    }

    public function Update_Student($request)
    {
        try {
            $Edit_Students = Student::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->nationalitie_id = $request->nationalitie_id;
            $Edit_Students->blood_id = $request->blood_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            $notification = array(
                'message' => 'Data Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Students.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    // delete
    public function delete_student($request){
        try {
            //Student::destroy($request->id);
            Student::findOrFail($request->id)->delete();
            $notification = array(
                'message' => 'Deleted successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Students.index')->with($notification);
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}