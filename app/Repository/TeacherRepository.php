<?php

namespace App\Repository;
use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

Class TeacherRepository implements TeacherRepositoryInterface{
    public function getAllTeachers()
    {
        return Teacher::all();
    }

    public function getSpecializations()
    {
        return Specialization::all();
    }

    public function getGender()
    {
        return Gender::all();
    }

    public function StoreTeachers($request){

        try {
            $Teachers = new Teacher();
            $Teachers->Email = $request->Email;
            $Teachers->Password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            $notification = array(
                'message' => 'Data Has Been Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Teachers.index')->with($notification);
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    public function getEditTeachers($id){
        return Teacher::findOrFail($id);
    }

    public function updateTeachers($request){
        try {
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->Email = $request->Email;
            $Teachers->Password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            $notification = array(
                'message' => 'Data Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Teachers.index')->with($notification);
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function deleteTeacher($request){

        try {
            Teacher::findOrFail($request->id)->delete();
            $notification = array(
                'message' => 'Data Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->route('Teachers.index')->with($notification);
        }catch (\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

}
