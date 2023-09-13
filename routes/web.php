<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Exams\ExamsController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Section\SectionController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Students\FeeInvoiceController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\LibraryController;
use App\Http\Controllers\Students\OnlineClassController;
use App\Http\Controllers\Students\PaymentStudentController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\PromotionsController;
use App\Http\Controllers\Students\ReceiptStudentController;
use App\Http\Controllers\Students\StudentsController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teachers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Auth::routes();
Route::get('/' , [HomeController::class , 'index'])->name('selection'); //

Route::get('login/{type}', [LoginController::class , 'loginForm'])->middleware('guest')->name('login.show');
Route::post('login', [LoginController::class , 'login'])->name('login');  // have Request
Route::get('logout/{type}', [LoginController::class , 'logout'])->name('logout');



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
    ], function(){

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    //grade
    Route::get('grades' , [GradeController::class , 'index'])->name('grades.index');
    Route::post('storeGrade' , [GradeController::class , 'storeGrade'])->name('grades.store');
    Route::post('updateGrade' , [GradeController::class , 'updateGrade'])->name('grade.update');
    Route::post('deleteGrade' , [GradeController::class , 'destroyGrade'])->name('grade.destroy');

    //classroom
    Route::get('classroom',[ClassroomController::class ,'index'])->name('classroom.index');
    Route::post('storeClass',[ClassroomController::class ,'storeClass'])->name('classroom.store');
    Route::post('updateClass',[ClassroomController::class ,'updateClass'])->name('classroom.update');
    Route::post('deleteClass',[ClassroomController::class ,'destroyClass'])->name('classroom.destroy');
    Route::post('delete_all',[ClassroomController::class ,'delete_all'])->name('delete_all');
    Route::post('Filter_Classes',[ClassroomController::class ,'Filter_Classes'])->name('Filter_Classes');

    //Sections
    Route::get('Sections', [SectionController::class ,'index'])->name('Sections.index');
    Route::post('storeSections',[SectionController::class ,'storeSections'])->name('Sections.store');
    Route::post('updateSection',[SectionController::class ,'updateSection'])->name('Sections.update');
    Route::post('destroySection',[SectionController::class ,'destroySection'])->name('Sections.destroy');
    Route::get('classes/{id}',[SectionController::class ,'getClasses']);


    //online classe
    Route::resource('online_classes', OnlineClassController::class);
    Route::get('indirectCreate', [OnlineClassController::class , 'indirectCreate'])->name('indirect.create');
    Route::post('storeIndirect', [OnlineClassController::class , 'storeIndirect'])->name('indirect.store');


    // Parents
    Route::view('Add_parent','livewire.show_form')->name('add_parent');  // route to view directly

    //==============================Teachers============================
    Route::resource('Teachers', TeacherController::class);

    //==============================Students============================
    Route::resource('Students', StudentsController::class);
//    Route::get('/Get_classrooms/{id}',[StudentsController::class ,'Get_classrooms']);
//    Route::get('/Get_Sections/{id}',[StudentsController::class ,'Get_Sections']);
    Route::post('Upload_attachment',[StudentsController::class ,'Upload_attachment'])->name('Upload_attachment');
    Route::get('Download_attachment/{studentsname}/{filename}', [StudentsController::class ,'Download_attachment'])->name('Download_attachment');
    Route::post('Delete_attachment', [StudentsController::class , 'Delete_attachment'])->name('Delete_attachment');


    //==============================Promotion Students============================
    Route::resource('Promotion', PromotionsController::class);
    //==============================Graduated Students============================
    Route::resource('Graduated', GraduatedController::class);
    Route::post('graduateStudent',[GraduatedController::class , 'GraduateStudent'])->name('Graduated.GraduateOneStudent');


    //==============================Fees============================
    Route::resource('Fees', FeesController::class);
    //==============================Fees Invoices============================
    Route::resource('Fees_Invoices', FeeInvoiceController::class);
    //==============================receipt students============================
    Route::resource('receipt_students', ReceiptStudentController::class);
    //==============================Processing Fee============================
    Route::resource('ProcessingFee', ProcessingFeeController::class);
    //==============================Payment_students============================
    Route::resource('Payment_students', PaymentStudentController::class);
    //==============================Attendance============================
    Route::resource('Attendance', AttendanceController::class);
    //==============================Attendance============================
    Route::resource('subjects', SubjectController::class);
    //==============================Exams============================
    Route::resource('Exams', ExamsController::class);
    //==============================Quizzes============================
    Route::resource('Quizzes', QuizzController::class);
    //==============================questions============================
    Route::resource('questions', QuestionsController::class);
    //==============================library============================
    Route::resource('library', LibraryController::class);
    Route::get('download_file/{filename}', [LibraryController::class,'downloadAttachment'])->name('downloadAttachment');

    //==============================library============================
    Route::resource('settings', settingController::class);


});





