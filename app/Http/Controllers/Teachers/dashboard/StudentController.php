<?php

namespace App\Http\Controllers\Teachers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $ids = DB::table('teachers_sections')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
      //  return $students;
        return view('pages.Teachers.dashboard.students.index', compact('students'));
    }

    public function sections()
    {
        $ids = DB::table('teachers_sections')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $sections = Section::whereIn('id', $ids)->get();
        return view('pages.Teachers.dashboard.sections.index', compact('sections'));
    }

    public function attendance(Request $request)
    {

        try {

            $attenddate = date('Y-m-d');
            foreach ($request->attendences as $studentid => $attendence){

                if ($attendence == 'presence'){
                    $attendence_status = true;
                } else if ($attendence == 'absent'){
                    $attendence_status = false;
                }

                Attendance::updateorCreate(
                    [   // this array like---> where('student_id' => $studentid,'attendence_date' => $attenddate)
                        'student_id' => $studentid,
                        'attendence_date' => $attenddate
                    ],
                    [
                        'student_id' => $studentid,
                        'grade_id' => $request->grade_id,
                        'classroom_id' => $request->classroom_id,
                        'section_id' => $request->section_id,
                        'teacher_id' => 1,
                        'attendence_date' => $attenddate,
                        'attendence_status' => $attendence_status
                    ]);

//                Attendance::create([
//                    'student_id' => $studentid,
//                    'grade_id' => $request->grade_id,
//                    'classroom_id' => $request->classroom_id,
//                    'section_id' => $request->section_id,
//                    'teacher_id' => 1,
//                    'attendence_date' => $attenddate,
//                    'attendence_status' => $attendence_status
//                ]);
            }
            $notification = array(
                'message' => 'Data Has Been Add successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('student.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editAttendance(Request $request){

        try{
            $date = date('Y-m-d');
            $student_id = Attendance::where('attendence_date',$date)->where('student_id',$request->id)->first();
            if( $request->attendences == 'presence' ) {
                $attendence_status = true;
            } else if( $request->attendences == 'absent' ){
                $attendence_status = false;
            }
            $student_id->update([
                'attendence_status'=> $attendence_status
            ]);
            $notification = array(
                'message' => 'Data Has Been Updated successfully',
                'alert-type'=> 'success',
            );
            return redirect()->route('student.index')->with($notification);
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function attendanceReport()
    {

        $ids = DB::table('teachers_sections')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();
        return view('pages.Teachers.dashboard.students.attendance_report', compact('students'));

    }

    public function attendanceSearch(Request $request)
    {

        //return $request;
        $request->validate([
            'from' => 'required|date|date_format:Y-m-d',
            'to' => 'required|date|date_format:Y-m-d|after_or_equal:from'
        ], [
            'to.after_or_equal' => 'تاريخ النهاية لابد ان اكبر من تاريخ البداية او يساويه',
            'from.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
            'to.date_format' => 'صيغة التاريخ يجب ان تكون yyyy-mm-dd',
        ]);


        $ids = DB::table('teachers_sections')->where('teacher_id', auth()->user()->id)->pluck('section_id');
        $students = Student::whereIn('section_id', $ids)->get();

        if ($request->student_id == 0) {

            $Attendance = Attendance::whereBetween('attendence_date', [$request->from, $request->to])->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Attendance', 'students'));
        } else {

            $Attendance = Attendance::whereBetween('attendence_date', [$request->from, $request->to])
                ->where('student_id', $request->student_id)->get();
            return view('pages.Teachers.dashboard.students.attendance_report', compact('Attendance', 'students'));

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
}
