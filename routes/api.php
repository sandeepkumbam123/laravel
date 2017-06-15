<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


Route::post('login', 'API\UserAPIController@login');
Route::post('user/search-student', 'API\UserAPIController@searchStudent');


//Exams Resources
Route::post('exams', 'API\ExamAPIController@get_all_exams');
Route::post('exam/enable', 'API\ExamAPIController@enable_exam');
Route::post('exam/disable', 'API\ExamAPIController@disable_exam');
Route::post('exam/start-exam', 'API\ExamAPIController@getQuestions');
Route::post('exam/submit-exam', 'API\ExamAPIController@submitExam');
Route::post('exam/delete-exam', 'API\ExamAPIController@delete_exam');
Route::post('exam/past-exams', 'API\ExamAPIController@get_exam_history');
Route::post('exam/past-exam-result', 'API\ExamAPIController@get_past_result');
Route::post('exam/one-student-past-exams', 'API\ExamAPIController@get_student_exam_history');





