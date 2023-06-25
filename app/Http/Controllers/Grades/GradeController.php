<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\StoreGradeRequest;
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
  public function store(StoreGradeRequest $request)
  {
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
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {

  }

}

?>
