<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Students\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(
        ['middleware' => 'auth:teacher,web'],
    function () {
        Route::get('/Get_classrooms/{id}',[AjaxController::class ,'Get_classrooms']);
        Route::get('/Get_Sections/{id}',[AjaxController::class ,'Get_Sections']);
    });

