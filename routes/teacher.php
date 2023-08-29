<?php

use App\Http\Controllers\Exams\ExamsController;
use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Teachers\dashboard\OnlineZoomClassesController;
use App\Http\Controllers\Teachers\dashboard\ProfileController;
use App\Http\Controllers\Teachers\dashboard\QuizzesController;
use App\Http\Controllers\Teachers\dashboard\StudentController;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        $ids = Teacher::findorFail(auth()->user()->id)->Sections()->pluck('section_id');
        $data['count_sections']= $ids->count();
        $data['count_students']= Student::whereIn('section_id',$ids)->count();

        // another way
//        $ids = DB::table('teacher_section')->where('teacher_id',auth()->user()->id)->pluck('section_id');
//        $count_sections =  $ids->count();
//        $count_students = DB::table('students')->whereIn('section_id',$ids)->count();
        return view('pages.Teachers.dashboard.dashboard',$data);
    });


        //==============================students============================
        Route::get('student',[StudentController::class , 'index'])->name('student.index');

        Route::get('sections',[StudentController::class , 'sections'])->name('sections');
        Route::post('attendance',[StudentController::class , 'attendance'])->name('attendance');

        Route::post('edit_attendance',[StudentController::class , 'editAttendance'])->name('attendance.edit');
        Route::get('attendance_report',[StudentController::class , 'attendanceReport'])->name('attendance.report');
        Route::post('attendance_report',[StudentController::class , 'attendanceSearch'])->name('attendance.search');
        Route::resource('quizzes', QuizzesController::class);
        Route::resource('questions', QuestionsController::class);
        Route::resource('online_zoom_classes', OnlineZoomClassesController::class);
        Route::get('/indirect', [OnlineZoomClassesController::class,'indirectCreate'])->name('indirect.teacher.create');
        Route::post('/indirect', [OnlineZoomClassesController::class,'storeIndirect'])->name('indirect.teacher.store');
        Route::get('profile', [ProfileController::class,'index'])->name('profile.show');
        Route::post('profile/{id}', [ProfileController::class,'update'])->name('profile.update');
        Route::get('student_quizze/{id}',[QuizzesController::class,'student_quizze'])->name('student.quizze');
        Route::post('repeat_quizze', [QuizzesController::class,'repeat_quizze'])->name('repeat.quizze');




});
