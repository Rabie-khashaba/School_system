<?php

namespace App\Http\Controllers\Classroom;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Http\Requests\StoreClassRequest;
use App\Models\Classroom;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return
   */
  public function index()
  {
        $My_Classes = Classroom::all();
        $Grades = Grade::all();
        return view('pages.My_Classes.My_Classes', compact('My_Classes','Grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return
   */
  public function storeClass(StoreClassRequest $request)
  {

//      $this->validate($request,[
//          'Name'=>'required',
//          'Name_class_en'=>'required',
//      ],[
//          'Name.request'=>trans('validation.required'),
//          'Name_class_en.request'=>trans('validation.required'),
//      ]);
      try {
          //$validate = $request->validated();
          $list_Classes = $request->List_Classes;
          //return $list_Classes;
          foreach ($list_Classes as $list_Class){
              $My_Classes = new Classroom();
              $My_Classes->Name = ['en'=>$list_Class['Name_class_en'] , 'ar'=>$list_Class['Name_class']];
              $My_Classes->Grade_id = $list_Class['Grade_id'];
              $My_Classes->save();
          }

          $notification = array(
              'message' => 'Data Has Been Saved successfully',
              'alert-type'=> 'success',
          );
          return redirect()->route('classroom.index')->with($notification);


      }catch (\Exception $exception){
          return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
      }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return
   */
  public function updateClass(Request $request)
  {
      try {
          //return $request;
          $classroom= Classroom::findOrFail($request->id);
          //return $classrooms;
          $classroom->update([
                $classroom->Name = ['en'=>$request->Name_en,'ar'=>$request->Name],
                $classroom->Grade_id = $request->Grade_id
          ]);

          $notification = array(
              'message' => 'Data Has Been Updated successfully',
              'alert-type'=> 'success',
          );
          return redirect()->route('classroom.index')->with($notification);

      }catch (\Exception $exception){
          return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
      }

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return
   */
  public function destroyClass(Request $request)
  {
      try {
          $classroom = Classroom::findOrFail($request->id);
          $classroom->delete();
          $notification = array(
              'message' => 'Deleted successfully',
              'alert-type'=> 'error',
          );
          return redirect()->route('classroom.index')->with($notification);

      }catch (\Exception $exception){
          return redirect()->back()->withErrors(['error'=>$exception->getMessage()]);
      }

  }


  public function delete_all(Request $request){
      //return $request;
      $delete_all_id = explode(",", $request->delete_all_id);

      // dd($delete_all_id);

      Classroom::whereIn('id', $delete_all_id)->Delete();  // whereIn take array
      $notification = array(
          'message' => 'Deleted successfully',
          'alert-type'=> 'error',
      );
      return redirect()->route('classroom.index')->with($notification);


  }

    public function Filter_Classes(Request $request)
    {

        //return $request;
        $My_Classes = Classroom::all();
        $Grades = Grade::all();


        $Search = Classroom::select('*')->where('Grade_id','=',$request->Grade_id)->get();
        return view('pages.My_Classes.My_Classes',compact('Grades','My_Classes'))->withDetails($Search);

    }

}

?>
