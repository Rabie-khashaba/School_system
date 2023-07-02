<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\StoreGradeRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
      $Grades = Grade::all(); // all data
      return view('pages.grades.grades' , compact('Grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function storeGrade(StoreGradeRequest $request)
  {
        // validation for unique
    //      if(Grade::where('name->ar',$request->name)->orWhere('name->en',$request->name_en)->exists()){
    //          return redirect()->back()->withErrors(['error'=> 'This Field Exist Before ']);
    //      }

      // another way in StoreGradeRequest.php


      try {
          $validate = $request->validated();

          $Grade = new Grade();
          /* first way //

              $translations = [
                  'en' => $request->Name_en,
                  'ar' => $request->Name
              ];
              $Grade->setTranslations('Name', $translations);
          */

          $Grade->name = ['en'=>$request->name_en ,'ar'=>$request->name];
          $Grade->notes = $request->notes;
          $Grade->save();

          $notification = array(
              'message' => 'Data Has Been Saved successfully',
              'alert-type'=> 'success',
          );
          return redirect()->route('grades.index')->with($notification);

      }catch (\Exception $exception){
          return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
      }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit( )
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function updateGrade(StoreGradeRequest $request)
  {
      try{
          $validate = $request->validated();

          $Grade = Grade::findOrFail($request->id);

          $Grade->update([
              $Grade->name = ['en'=>$request->name_en ,'ar'=>$request->name],
              $Grade->notes = $request->notes
          ]);

          $notification = array(
              'message' => 'Data Has Been Updated successfully',
              'alert-type'=> 'success',
          );
          return redirect()->route('grades.index')->with($notification);

      }catch (\Exception $exception){
          return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
      }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroyGrade(Request $request)
  {
      // check if grade has classrooms and get grade_id(classrooms) in array
      $my_class_id = Classroom::where('Grade_id' , $request->id)->pluck('Grade_id');  // return all grade_id in array

      if ($my_class_id->count() == 0 ){
          $Grade = Grade::findOrFail($request->id);
          //return $Grade;
          $Grade->delete();

          $notification = array(
              'message' => 'Delete successfully',
              'alert-type'=> 'error',
          );
          return redirect()->route('grades.index')->with($notification);

      }else{
          $notification = array(
              'message' => 'Can Not Delete This Grade, it has Classrooms',
              'alert-type'=> 'error',
          );
          return redirect()->route('grades.index')->with($notification);

      }


  }

}

?>
