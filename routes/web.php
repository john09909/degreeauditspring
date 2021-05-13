<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::post("crop", "ProfileController@postCrop"); // to handle AJAX image 

Route::post("save_callback" ,"Course@save_callback");
Route::get("delete_div/{div_id}/{page_id}", "Course@delete_div");
Route::get("max_div_id/{page_id}/{student_id}", "Course@max_div_id");

Route::get("student/{student_id}","Course@page");
Route::post("student/freshman", "Home@freshman");
Route::post("page/new_pdf_data","Course@parse_pdf");
Route::post("parse_pdf", "Course@parse_pdf");

Route::post("new/user", "Course@new_user");
Route::post("see_details/{student_id}","Course@see_details");
Route::post("red_label_card","Course@red_label_card");
