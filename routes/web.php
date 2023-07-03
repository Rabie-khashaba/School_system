<?php

use App\Http\Controllers\Classroom\ClassroomController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Section\SectionController;
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

Auth::routes();

Route::group(['middleware'=>'guest'] , function (){  // only not authenticated can enter this route
    Route::get('/', function()
    {
        return view('auth.login');
    });
});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
    ], function(){

    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

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
    Route::get('sections',[SectionController::class ,'index'])->name('sections.index');
    Route::post('storeSections',[SectionController::class ,'storeSections'])->name('Sections.store');
    Route::post('updateSection',[SectionController::class ,'updateSection'])->name('Sections.update');
    Route::post('destroySection',[SectionController::class ,'destroySection'])->name('Sections.destroy');
    Route::get('classes/{id}',[SectionController::class ,'getClasses']);




});





