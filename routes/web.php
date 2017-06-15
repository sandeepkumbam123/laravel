<?php

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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//USER Resources
/********************* user ***********************************************/
Route::group(['middleware' => 'web'], function () {
	Route::get('secure/login', 'LoginController@index');
	Route::get('secure/dashboard', 'LoginController@viewDashboard');
	Route::get('secure/logout', 'LoginController@logout');
	Route::post('secure/login', 'LoginController@do_admin_login');


	/*Route::get('secure/changepassword', 'LoginController@resetPassword');
	Route::post('secure/updatePassword', 'LoginController@updatePassword');*/
});
/********************* user ***********************************************/


//branch Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/branch', '\App\Http\Controllers\BranchController');
	Route::post('portal/branch/{id}/update', '\App\Http\Controllers\BranchController@update');
	Route::get('portal/branch/{id}/delete', '\App\Http\Controllers\BranchController@destroy');
	Route::get('portal/branch/{id}/deleteMsg', '\App\Http\Controllers\BranchController@DeleteMsg');
});


//class_name Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/class', '\App\Http\Controllers\Class_nameController');
	Route::post('portal/class/{id}/update', '\App\Http\Controllers\Class_nameController@update');
	Route::get('portal/class/{id}/delete', '\App\Http\Controllers\Class_nameController@destroy');
	Route::get('portal/class/{id}/deleteMsg', '\App\Http\Controllers\Class_nameController@DeleteMsg');
});


//subject Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/subject', '\App\Http\Controllers\SubjectController');
	Route::post('portal/subject/{id}/update', '\App\Http\Controllers\SubjectController@update');
	Route::get('portal/subject/{id}/delete', '\App\Http\Controllers\SubjectController@destroy');
	Route::get('portal/subject/{id}/deleteMsg', '\App\Http\Controllers\SubjectController@DeleteMsg');
});


//section Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/section', '\App\Http\Controllers\SectionController');
	Route::post('portal/section/{id}/update', '\App\Http\Controllers\SectionController@update');
	Route::get('portal/section/{id}/delete', '\App\Http\Controllers\SectionController@destroy');
	Route::get('portal/section/{id}/deleteMsg', '\App\Http\Controllers\SectionController@DeleteMsg');
});


//chapter Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/chapter', '\App\Http\Controllers\ChapterController');
	Route::post('portal/chapter/{id}/update', '\App\Http\Controllers\ChapterController@update');
	Route::get('portal/chapter/{id}/delete', '\App\Http\Controllers\ChapterController@destroy');
	Route::get('portal/chapter/{id}/deleteMsg', '\App\Http\Controllers\ChapterController@DeleteMsg');


});

//question Routes
Route::group(['middleware' => 'web'], function () {
	Route::resource('portal/question', '\App\Http\Controllers\QuestionController');
	Route::post('portal/question/{id}/update', '\App\Http\Controllers\QuestionController@update');
	Route::get('portal/question/{id}/delete', '\App\Http\Controllers\QuestionController@destroy');
	Route::get('portal/question/{id}/deleteMsg', '\App\Http\Controllers\QuestionController@DeleteMsg');
});

//CSV Routes
Route::get('portal/upload-question/', '\App\Http\Controllers\CsvController@index');
Route::post('portal/upload-questions/', '\App\Http\Controllers\CsvController@storeQuestions');


//exam Routes
Route::group(['middleware' => 'web'], function () {
	/*Route::resource('portal/exam', '\App\Http\Controllers\ExamController');
	Route::post('portal/exam/{id}/update', '\App\Http\Controllers\ExamController@update');*/
	Route::get('portal/exam/{id}/delete', '\App\Http\Controllers\ExamController@destroy');
	Route::get('portal/exam/{id}/deleteMsg', '\App\Http\Controllers\ExamController@DeleteMsg');

	Route::post('portal/search-questions', '\App\Http\Controllers\ExamController@search_questions');
	Route::get('portal/search-questions', '\App\Http\Controllers\ExamController@search_questions_form');
	Route::post('portal/create-exam', '\App\Http\Controllers\ExamController@createExam');
	Route::get('portal/exam-list', '\App\Http\Controllers\ExamController@index');
	Route::get('portal/editexam-stepone/{id}/edit', '\App\Http\Controllers\ExamController@editStep_one');
	Route::post('portal/editexam-stepone', '\App\Http\Controllers\ExamController@editStep_one_selectQuestions');
	Route::post('portal/update-exam', '\App\Http\Controllers\ExamController@updateExam');

	Route::get('portal/exam/upload', '\App\Http\Controllers\ExamController@show_upload_exam_form');
	Route::post('portal/exam/upload', '\App\Http\Controllers\ExamController@upload_exam');
	Route::get('portal/exam/generate-exam', '\App\Http\Controllers\ExamController@show_dynamic_exam_form');
	Route::post('portal/exam/generate-exam', '\App\Http\Controllers\ExamController@generate_exam');


});

//USER Routes
Route::group(['middleware' => 'web'], function () {
	Route::get('portal/user/upload', '\App\Http\Controllers\UserController@show_upload_form');
	Route::post('portal/user/upload-user', '\App\Http\Controllers\UserController@upload_user');

	Route::resource('portal/user', '\App\Http\Controllers\UserController');
	Route::post('portal/user/{id}/update', '\App\Http\Controllers\UserController@update');
	Route::get('portal/user/{id}/delete', '\App\Http\Controllers\UserController@destroy');
	Route::get('portal/user/{id}/deleteMsg', '\App\Http\Controllers\UserController@DeleteMsg');


});

//TEACHER Routes
Route::group(['middleware' => 'web'], function () {

	Route::resource('portal/teacher', '\App\Http\Controllers\TeacherController');
	Route::post('portal/teacher/{id}/update', '\App\Http\Controllers\TeacherController@update');
	Route::get('portal/teacher/{id}/delete', '\App\Http\Controllers\TeacherController@destroy');
	Route::get('portal/teacher/{id}/deleteMsg', '\App\Http\Controllers\TeacherController@DeleteMsg');


	//Teacher Roles
	Route::get('portal/teacher/{id}/roles', '\App\Http\Controllers\TeacherController@getRolesList');
	Route::get('portal/teacher/{id}/create', '\App\Http\Controllers\TeacherController@showAddRole_form');
	Route::post('portal/teacher/saveRole', '\App\Http\Controllers\TeacherController@saveRole');
	Route::get('portal/role/{id}/deleteRoleMsg/{userID}', '\App\Http\Controllers\TeacherController@DeleteRoleMsg');
	Route::get('portal/role/{id}/deleteRole/{userID}', '\App\Http\Controllers\TeacherController@destroyRole');

});


//syllabus Routes
Route::group(['middleware'=> 'web'],function(){
	Route::resource('portal/syllabus','\App\Http\Controllers\SyllabusController');
	Route::post('portal/syllabus/{id}/update','\App\Http\Controllers\SyllabusController@update');
	Route::get('portal/syllabus/{id}/delete','\App\Http\Controllers\SyllabusController@destroy');
	Route::get('portal/syllabus/{id}/deleteMsg','\App\Http\Controllers\SyllabusController@DeleteMsg');
});




Route::post('secure/get_avil_classes', 'CommonController@getClasses');
Route::post('secure/get_avil_subjects', 'CommonController@getSubjects');
Route::post('secure/get_avil_chapters', 'CommonController@getChapters');
Route::post('secure/get_avil_sections', 'CommonController@getSections');





Route::get('/', function () {
	return view('auth.login');
});
