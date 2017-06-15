<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Question;
use App\QuestionOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exam;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;
use League\Csv\Reader;

/**
 * Class ExamController.
 *
 * @author  The scaffold-interface created at 2017-06-01 01:01:58pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class ExamController extends Controller {

	protected $query_operator = '';
	protected $field_value = '';
	protected $constant = array();
	protected $csv_location = '/csv/';

	public function __construct() {
		$this->middleware('portalUser', ['except' => []]);
		$this->constant = Config::get('constants.DEFAULT_DATA');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function index() {

		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$this->query_operator = '!=';
			$this->field_value = '';
		} else {
			$this->query_operator = '=';
			$this->field_value = Session::get('branch_id');
		}
		$subjects = DB::table('subjects')->get();
		$exams = DB::table('exams')
			//->whereIn('subjects', 'subjects.subjectID', '=', 'questions.subjects_subjectID')
			//->join('chapters', 'chapters.chapterID', '=', 'questions.chapters_chapterID')
			->join('class_names', 'class_names.classID', '=', 'exams.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'exams.branches_branchID')
			->where('branches.branchID', $this->query_operator, $this->field_value)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('exams.deleted_at')
			->select('exams.*', 'branches.branch_name', 'branches.branchID', "class_names.class_name", "class_names.classID")
			->orderBy("branches.branchID")
			->get();

		return view('exam.index', compact('exams', 'const_role_name', 'subjects'));
	}


	public function search_questions_form() {

		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$uniqid = strtoupper(bin2hex(openssl_random_pseudo_bytes(6)));
		return view('exam.create_step_1', compact('critical_level', 'all_branches', 'const_role_name', 'uniqid'));
	}


	public function search_questions(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapterIDS.required' => 'This chapter  field is required.',
			//'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];
		$validation_rule = Validator::make($request->all(), [
			'subjectIDS' => 'required',
			'chapterIDS' => 'required',
			'class_names_classID' => 'required',
			'branches_branchID' => 'required',
			'duration' => 'required',
			'pass_percentage' => 'required',
			'total_marks' => 'required',
			'critical_level' => 'required',
			'exam_manualID' => 'required|unique:exams,exam_manualID',
			'exam_date' => 'required',
			'title' => 'required',
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$critical_level = Config::get('constants.EXAM_CRITICAL');
			$subject_list = DB::table('subjects')
				->whereIn('subjectID', $request->subjectIDS)->get();
			$chapter_list = DB::table('chapters')
				->whereIn('chapterID', $request->chapterIDS)->get();
			$class_data = DB::table('class_names')
				->where('classID', '=', $request->class_names_classID)->get();

			$chapter_list = $this->get_data($chapter_list, "chapterID", "chapter");
			$subject_list = $this->get_data($subject_list, "subjectID", "subject");
			$class_data = $class_data[0];


			$questions = DB::table('questions')
				->join('subjects', 'subjects.subjectID', '=', 'questions.subjects_subjectID')
				->join('chapters', 'chapters.chapterID', '=', 'questions.chapters_chapterID')
				->join('class_names', 'class_names.classID', '=', 'questions.class_names_classID')
				->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
				->where('class_names.branches_branchID', '=', $request->branches_branchID)
				->whereIn('questions.chapters_chapterID', $request->chapterIDS)
				->whereIn('questions.subjects_subjectID', $request->subjectIDS)
				->whereNull('class_names.deleted_at')
				->whereNull('subjects.deleted_at')
				->whereNull('chapters.deleted_at')
				->whereNull('questions.deleted_at')
				->select('questions.*', 'branches.branch_name', 'chapters.chapter', 'subjects.subject', 'class_names.branches_branchID', "class_names.class_name", "class_names.classID")
				->get();
			$input_data = $request->all();


			return view('exam.create_step_2', compact('input_data', 'questions', 'chapter_list', 'subject_list', 'class_data', 'critical_level'));


		}

	}

	public function createExam(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'selected_questions.required' => 'Please Choose at least one question',
		];

		$validation_rule = Validator::make($request->all(), [
			'selected_questions' => 'required'
		], $messages);


		if ($validation_rule->fails()) {

			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {

			$exam = new Exam();


			$exam->class_names_classID = $request->class_names_classID;


			$exam->branches_branchID = $request->branches_branchID;

			$a = (string)implode(",", $request->subjectIDS);
			$exam->subjectIDS = $a;

			$b = (string)implode(",", $request->chapterIDS);
			$exam->chapterIDS = $b;


			$exam->exam_manualID = $request->exam_manualID;


			$exam->title = $request->title;


			$exam->critical_level = $request->critical_level;


			$exam->total_marks = $request->total_marks;


			$exam->pass_percentage = $request->pass_percentage;


			$exam->is_active = "true";


			$exam->exam_date = $request->exam_date;


			$exam->negative_mark = $request->negative_mark;


			$exam->duration = $request->duration;


			$exam->note = $request->note != NULL ? $request->note : "NULL";

			$q = (string)implode(",", $request->selected_questions);

			$exam->questions = $q;

			$status = $exam->save();
			if ($status) {
				Session::flash('status', 'The New Exam created Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}
		return redirect('portal/exam-list');
	}


	public function editStep_one($id, Request $request) {
		if ($request->ajax()) {
			return URL::to('portal/editexam-stepone/' . $id . '/edit');
		}


		$exam = DB::table('exams')
			->where("examId", '=', $id)->get();
		$exam = $exam[0];
		$const_role_name = $this->constant['super_admin'];
		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}


		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$subject_list = DB::table('subjects')
			->whereIn('subjectID', explode(",", $exam->subjectIDS))->get();
		$chapter_list = DB::table('chapters')
			->whereIn('chapterID', explode(",", $exam->chapterIDS))->get();
		$class_data = DB::table('class_names')
			->where('classID', '=', $exam->class_names_classID)->get();


		$chapter_list = $this->get_data($chapter_list, "chapterID", "chapter");

		$subject_list = $this->get_data($subject_list, "subjectID", "subject");
		$class_data = $class_data[0];


		return view('exam.edit_step_one', compact('all_branches', 'critical_level', 'exam', 'chapter_list', 'subject_list', 'class_data', 'const_role_name'));
	}


	public function editStep_one_selectQuestions(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapterIDS.required' => 'This chapter  field is required.',
			//'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];
		$validation_rule = Validator::make($request->all(), [
			'subjectIDS' => 'required',
			'chapterIDS' => 'required',
			'class_names_classID' => 'required',
			'branches_branchID' => 'required',
			'duration' => 'required',
			'pass_percentage' => 'required',
			'total_marks' => 'required',
			'critical_level' => 'required',
			//'exam_manualID' => 'required|unique:exams,exam_manualID',
			'exam_date' => 'required',
			'title' => 'required',
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$critical_level = Config::get('constants.EXAM_CRITICAL');
			$subject_list = DB::table('subjects')
				->whereIn('subjectID', $request->subjectIDS)->get();
			$chapter_list = DB::table('chapters')
				->whereIn('chapterID', $request->chapterIDS)->get();
			$class_data = DB::table('class_names')
				->where('classID', '=', $request->class_names_classID)->get();

			$chapter_list = $this->get_data($chapter_list, "chapterID", "chapter");
			$subject_list = $this->get_data($subject_list, "subjectID", "subject");
			$class_data = $class_data[0];


			$questions = DB::table('questions')
				->join('subjects', 'subjects.subjectID', '=', 'questions.subjects_subjectID')
				->join('chapters', 'chapters.chapterID', '=', 'questions.chapters_chapterID')
				->join('class_names', 'class_names.classID', '=', 'questions.class_names_classID')
				->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
				->where('class_names.branches_branchID', '=', $request->branches_branchID)
				->whereIn('questions.chapters_chapterID', $request->chapterIDS)
				->whereIn('questions.subjects_subjectID', $request->subjectIDS)
				->whereNull('class_names.deleted_at')
				->whereNull('subjects.deleted_at')
				->whereNull('chapters.deleted_at')
				->whereNull('questions.deleted_at')
				->select('questions.*', 'branches.branch_name', 'chapters.chapter', 'subjects.subject', 'class_names.branches_branchID', "class_names.class_name", "class_names.classID")
				->get();
			$input_data = $request->all();
			$old_questions = explode(",", $request->old_questions);

			return view('exam.edit_step_two', compact('input_data', 'questions', 'chapter_list', 'subject_list', 'class_data', 'critical_level', 'old_questions'));
		}
	}


	public function updateExam(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'selected_questions.required' => 'Please Choose at least one question',
		];

		$validation_rule = Validator::make($request->all(), [
			'selected_questions' => 'required'
		], $messages);


		if ($validation_rule->fails()) {

			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {


			$exam = Exam::findOrfail($request->examID);

			$exam->class_names_classID = $request->class_names_classID;


			$exam->branches_branchID = $request->branches_branchID;

			$a = (string)implode(",", $request->subjectIDS);
			$exam->subjectIDS = $a;

			$b = (string)implode(",", $request->chapterIDS);
			$exam->chapterIDS = $b;


			$exam->exam_manualID = $request->exam_manualID;


			$exam->title = $request->title;


			$exam->critical_level = $request->critical_level;


			$exam->total_marks = $request->total_marks;


			$exam->pass_percentage = $request->pass_percentage;


			$exam->is_active = "true";


			$exam->exam_date = $request->exam_date;


			$exam->negative_mark = $request->negative_mark;


			$exam->duration = $request->duration;


			$exam->note = $request->note != NULL ? $request->note : "";

			$q = (string)implode(",", $request->selected_questions);

			$exam->questions = $q;

			$status = $exam->save();
			if ($status) {
				Session::flash('status', 'The Exam updated Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}
		return redirect('portal/exam-list');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {


		if ($request->ajax()) {
			return URL::to('portal/exam/' . $id);
		}

		$exam = Exam::findOrfail($id);
		return view('exam.show', compact('title', 'exam'));
	}


	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/exam/' . $id . '/delete');

		if ($request->ajax()) {
			return $msg;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$exam = Exam::findOrfail($id);
		$exam->delete();
		return URL::to('portal/exam-list');
	}


	public function show_upload_exam_form() {
		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$uniqid = strtoupper(bin2hex(openssl_random_pseudo_bytes(5)));
		return view('exam.upload', compact('critical_level', 'all_branches', 'uniqid', 'const_role_name', 'uniqid'));

	}

	public function upload_exam(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapterIDS.required' => 'This chapter  field is required.',
			//'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];
		$validation_rule = Validator::make($request->all(), [
			'subjectIDS' => 'required',
			'chapterIDS' => 'required',
			'class_names_classID' => 'required',
			'branches_branchID' => 'required',
			'duration' => 'required',
			'pass_percentage' => 'required',
			'total_marks' => 'required',
			'critical_level' => 'required',
			//'exam_manualID' => 'required|unique:exams,exam_manualID',
			'exam_date' => 'required',
			'title' => 'required',
			'csvFile' => 'required',
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$exam = new Exam();

			$exam->class_names_classID = $request->class_names_classID;


			$exam->branches_branchID = $request->branches_branchID;

			$a = (string)implode(",", $request->subjectIDS);
			$exam->subjectIDS = $a;

			$b = (string)implode(",", $request->chapterIDS);
			$exam->chapterIDS = $b;


			$exam->exam_manualID = $request->exam_manualID;


			$exam->title = $request->title;


			$exam->critical_level = $request->critical_level;


			$exam->total_marks = $request->total_marks;


			$exam->pass_percentage = $request->pass_percentage;


			$exam->is_active = "true";


			$exam->exam_date = $request->exam_date;


			$exam->negative_mark = $request->negative_mark;


			$exam->duration = $request->duration;


			$exam->note = $request->note != NULL ? $request->note : "";

			if ($request->hasFile('csvFile')) {
				$failed_rows = $added_ids = array();
				$file = Input::file('csvFile');
				$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
				$url = $this->csv_location . $timestamp . '-' . $file->getClientOriginalName();

				$file_path = $file->move(public_path() . $this->csv_location, $url);
				//$file_path = "/opt/lampp/htdocs/Quest/public/csv/2017-05-31-13-03-48-questions.csv";
				if ($file_path) {

					$temp = explode("\\", $file_path);
					$csvFile = end($temp);
					$reader = Reader::createFromPath(public_path() . '/csv/' . $csvFile);
					//$reader = Reader::createFromPath(public_path() . '/csv/' . "2017-05-31-13-03-48-questions.csv");
					$results = $reader->fetch();
					$ii = 0;
					$total = 0;


					foreach ($results as $row) {
						if ($ii > 0) {
							try {
								$question = new Question();
								$question->subjects_subjectID = $row[1];
								$question->chapters_chapterID = $row[2];;
								$question->syllabuses_syllabuseID = 1;
								$question->class_names_classID = $row[0];;
								$question->question = $row[3];
								$question->mark = $row[8];;
								$question->critical_level = $row[9];;
								$question->is_image = "no";
								$question->save();


								$question_options = new QuestionOption();
								$question_options->questions_questionID = $question->questionID;
								$question_options->option1 = $row[4];
								$question_options->option2 = $row[5];
								$question_options->option3 = $row[6];
								$question_options->option4 = $row[7];
								$question_options->answer = $row[10];
								$question_options->is_option1_image = 'no';
								$question_options->is_option2_image = 'no';
								$question_options->is_option3_image = 'no';
								$question_options->is_option4_image = 'no';
								//$question_options->notes = $row[8];
								$status = $question_options->save();
								if ($status) {
									$total += 1;
									$added_ids[] = $question->questionID;
								}

							} catch (QueryException $e) {
								$failed_rows[] = $ii;
							}
						}

						$ii += 1;
					}
				}
			}

			$q = (string)implode(",", $added_ids);

			$exam->questions = $q;

			$status = $exam->save();
			if ($status) {
				Session::flash('status', 'The Exam Created Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}
		return redirect('portal/exam-list');
	}

	public function show_dynamic_exam_form() {
		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$uniqid = strtoupper(bin2hex(openssl_random_pseudo_bytes(5)));
		return view('exam.dynamic_exam', compact('critical_level', 'all_branches', 'uniqid', 'const_role_name', 'uniqid'));

	}

	public function generate_exam(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapterIDS.required' => 'This chapter  field is required.',
			//'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];
		$validation_rule = Validator::make($request->all(), [
			'subjectIDS' => 'required',
			'chapterIDS' => 'required',
			'class_names_classID' => 'required',
			'branches_branchID' => 'required',
			'duration' => 'required',
			'pass_percentage' => 'required',
			'total_marks' => 'required',
			'critical_level' => 'required',
			//'exam_manualID' => 'required|unique:exams,exam_manualID',
			'exam_date' => 'required',
			'title' => 'required',

		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$exam = new Exam();

			$exam->class_names_classID = $request->class_names_classID;


			$exam->branches_branchID = $request->branches_branchID;

			$a = (string)implode(",", $request->subjectIDS);
			$exam->subjectIDS = $a;

			$b = (string)implode(",", $request->chapterIDS);
			$exam->chapterIDS = $b;

			$exam->exam_manualID = $request->exam_manualID;


			$exam->title = $request->title;


			$exam->critical_level = $request->critical_level;


			$exam->total_marks = $request->total_marks;


			$exam->pass_percentage = $request->pass_percentage;


			$exam->is_active = "true";


			$exam->exam_date = $request->exam_date;


			$exam->negative_mark = $request->negative_mark;


			$exam->duration = $request->duration;


			$exam->note = $request->note != NULL ? $request->note : "";
			$range = $request->total_marks + 30;

			$questions = DB::table('questions')
				->join('subjects', 'subjects.subjectID', '=', 'questions.subjects_subjectID')
				->join('chapters', 'chapters.chapterID', '=', 'questions.chapters_chapterID')
				->join('class_names', 'class_names.classID', '=', 'questions.class_names_classID')
				->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
				->where('class_names.branches_branchID', '=', 1)
				->whereIn('questions.chapters_chapterID', array(1, 2))
				->whereIn('questions.subjects_subjectID', array(1, 2))
				->whereNull('class_names.deleted_at')
				->whereNull('subjects.deleted_at')
				->whereNull('chapters.deleted_at')
				->whereNull('questions.deleted_at')
				->select('questions.*', 'branches.branch_name', 'chapters.chapter', 'subjects.subject', 'class_names.branches_branchID', "class_names.class_name", "class_names.classID")
				->inRandomOrder()
				->take($range)
				->get();

			$questions=json_decode($questions);
			echo "<pre>";

			$target_mark=0;$question_list=array();
			$total_mark=$request->total_marks;
			foreach ($questions as $question){
				if($target_mark<$total_mark){
					if(($target_mark+$question->mark)>$total_mark){
						continue;
					}else{
						$question_list[]=$question->questionID;
						$target_mark+=$question->mark;
					}

				}
				if($target_mark>$total_mark){
					break;
				}

			}unset($question);

			$q = (string)implode(",", $question_list);

			$exam->questions = $q;

			$status = $exam->save();
			if ($status) {
				Session::flash('status', 'The Exam Created Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}

		}
		return redirect('portal/exam-list');
	}


	public function tot() {


		/*echo '<pre>';
		print_r($questions);
		exit;*/
	}


	public function get_data($table_data, $id_field, $field_name) {
		$result = array();
		foreach ($table_data as $item) {

			$result[$item->$id_field] = $item->$field_name;
		}

		unset($item);
		return $result;
	}

	public static function objArraySearch($array, $index, $value) {
		foreach ($array as $arrayInf) {
			if ($arrayInf->{$index} == $value) {
				return $arrayInf;
			}
		}
		return null;
	}

}
