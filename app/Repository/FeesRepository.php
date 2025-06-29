<?php

namespace App\Repository;

use App\Models\Fee;
use App\Models\Grade;

class FeesRepository implements FeesRepositoryInterface
{
    public function index(){

        $fees = Fee::all();
        $Grades = Grade::all();
        return view('pages.Fees.index',compact('fees','Grades'));

    }

    public function create(){

        $Grades = Grade::all();
        return view('pages.Fees.add',compact('Grades'));
    }

    public function edit($id){

        $fee = Fee::findorfail($id);
        $Grades = Grade::all();
        return view('pages.Fees.edit',compact('fee','Grades'));

    }


    public function store($request)
    {
        try {

            $fees = new Fee();
            $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
            $fees->amount  =$request->amount;
            $fees->Grade_id  =$request->Grade_id;
            $fees->Classroom_id  =$request->Classroom_id;
            $fees->description  =$request->description;
            $fees->year  =$request->year;
            $fees->fee_type  =$request->Fee_type;
            $fees->save();

            $notification = array(
                'message' => 'Study Fees Saved successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Fees.create')->with($notification);


        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request)
    {
        try {
            $fees = Fee::findorfail($request->id);
            $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
            $fees->amount  =$request->amount;
            $fees->Grade_id  =$request->Grade_id;
            $fees->Classroom_id  =$request->Classroom_id;
            $fees->description  =$request->description;
            $fees->year  =$request->year;
           // $fees->fee_type  =$request->Fee_type;
            $fees->save();

            $notification = array(
                'message' => 'Study Fees Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('Fees.index')->with($notification);

        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Fee::destroy($request->id);
            $notification = array(
                'message' => 'Study Fees Deleted successfully',
                'alert-type'=> 'error',
            );
            return redirect()->route('Fees.index')->with($notification);


        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
