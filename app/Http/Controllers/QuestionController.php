<?php

namespace App\Http\Controllers;

use App\Branch;
use App\QuestionOption;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class QuestionController.
 *
 * @author  The scaffold-interface created at 2017-05-28 07:33:34am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class QuestionController extends Controller {

	protected $query_operator = '';
	protected $field_value = '';
	protected $constant = array();

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
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$this->query_operator = '!=';
			$this->field_value = '';
		} else {
			$this->query_operator = '=';
			$this->field_value = Session::get('branch_id');
		}


		$questions = DB::table('questions')
			->join('subjects', 'subjects.subjectID', '=', 'questions.subjects_subjectID')
			->join('chapters', 'chapters.chapterID', '=', 'questions.chapters_chapterID')
			->join('class_names', 'class_names.classID', '=', 'questions.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('subjects.deleted_at')
			->whereNull('chapters.deleted_at')
			->whereNull('questions.deleted_at')
			->select('questions.*', 'chapters.chapterID', 'chapters.chapter', 'branches.branch_name', 'subjects.subject', 'branches.branchID', "class_names.class_name", "class_names.classID")
			->orderBy("branches.branchID")
			->get();

		return view('question.index', compact('questions', 'critical_level'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function create() {
		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$answer_list = Config::get('constants.ANSWER_LIST');
		return view('question.create', compact('all_branches', 'const_role_name', 'critical_level', 'answer_list'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @return  \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$status = false;
		$input = $request->except('_token');
		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapters_chapterID.required' => 'This chapter is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];

		$rules = [
			'subjects_subjectID' => 'required',
			'chapters_chapterID' => 'required',
			'class_names_classID' => 'required',
			'mark' => 'required',
			'critical_level' => 'required',
			'branches_branchID' => 'required',
			'critical_level' => 'required',

			'answer' => 'required',
		];


		if ($input['question'] != '') {
			$rules['question'] = 'required|unique:questions';
		}

		if ((empty($input['image_question']) && empty($input['question']))) {

			$rules['question'] = 'required|unique:questions';
		}

		if ($input['option1'] != '') {
			$rules['option1'] = 'required';
		}

		if ((empty($input['option1_image']) && empty($input['option1']))) {

			$rules['option1'] = 'required';
		}


		if ($input['option2'] != '') {
			$rules['option2'] = 'required';
		}

		if ((empty($input['option2_image']) && empty($input['option2']))) {

			$rules['option2'] = 'required';
		}


		if ($input['option3'] != '') {
			$rules['option3'] = 'required';
		}

		if ((empty($input['option3_image']) && empty($input['option3']))) {

			$rules['option3'] = 'required';
		}

		if ($input['option4'] != '') {
			$rules['option4'] = 'required';
		}

		if ((empty($input['option4_image']) && empty($input['option4']))) {

			$rules['option4'] = 'required';
		}


		$validation_rule = Validator::make($request->all(), $rules, $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {

			/**TO DO: syllabus logic **/


			$question = new Question();


			$question->subjects_subjectID = $request->subjects_subjectID;


			$question->chapters_chapterID = $request->chapters_chapterID;

			$question->syllabuses_syllabuseID = 1;


			$question->class_names_classID = $request->class_names_classID;


			$is_img_question = false;
			if (!empty($request->question)) {
				$question->question = $request->question;
				$question->is_image = "no";
			} elseif (!empty($input['image_question'])) {
				$is_img_question = true;
				$question->is_image = "yes";
			}


			$question->mark = $request->mark;


			$question->critical_level = $request->critical_level;


			$question->is_image = $request->is_image == true ? "yes" : "no";


			$status = $question->save();


			if ($status && $question->questionID) {
				$status = false;
				$question_options = new QuestionOption();
				$question_options->questions_questionID = $question->questionID;

				$is_option1_image = $is_option2_image = $is_option3_image = $is_option4_image = false;
				if (!empty($request->option1)) {
					$question_options->option1 = $request->option1;
					$question->is_option1_image = "no";
				} elseif (!empty($input['option1_image'])) {
					$is_option1_image = true;
					$question->is_option1_image = "yes";
				}


				if (!empty($request->option2)) {
					$question_options->option2 = $request->option2;
					$question->is_option2_image = "no";
				} elseif (!empty($input['option2_image'])) {
					$is_option2_image = true;
					$question->is_option2_image = "yes";
				}


				if (!empty($request->option3)) {
					$question_options->option3 = $request->option3;
					$question->is_option3_image = "no";
				} elseif (!empty($input['option3_image'])) {
					$is_option3_image = true;
					$question->is_option3_image = "yes";
				}


				if (!empty($request->option4)) {
					$question_options->option4 = $request->option4;
					$question->is_option4_image = "no";
				} elseif (!empty($input['option4_image'])) {
					$is_option4_image = true;
					$question->is_option4_image = "yes";
				}


				$question_options->answer = $request->answer;
				$question_options->notes = $request->notes;
				$status = $question_options->save();

				if ($status) {

					if ($is_img_question) {
						if ($request->hasFile('image_question')) {
							$file = Input::file('image_question');

							$filename = $file->getClientOriginalName();
							$destinationPath = public_path() . "/questions/" . $question->questionID . '/';
							$file->move($destinationPath, $filename);

							$_question = Question::findOrfail($question->questionID);
							$_question->question = "/questions/" . $question->questionID . '/' . $filename;
							$_question->is_option3_image = "no";
							$_question->save();
						}
					}

					$update = [];
					for ($ii = 1; $ii <= 4; $ii++) {

						if (${'is_option' . $ii . '_image'}) {
							if ($request->hasFile('option' . $ii . '_image')) {
								$file = Input::file('option' . $ii . '_image');
								$filename = $file->getClientOriginalName();
								$destinationPath = public_path() . "/questions/" . $question->questionID . '/';
								$file->move($destinationPath, $filename);
								$update['is_option' . $ii . '_image'] = 'yes';
								$update['option' . $ii] = "/questions/" . $question->questionID . '/' . $filename;
							}
						}
					}
					if (count($update) > 0) {

						DB::table('question_options')
							->where('question_optionsID', $question_options->question_optionsID)
							->update($update);
					}


					Session::flash('status', 'The New Subject created Successfully');
				} else {
					Session::flash('status', 'OOPS! Something went wrong. Please try again');
				}
			}
		}
		return redirect('portal/question');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {
		$title = 'Show - question';

		if ($request->ajax()) {
			return URL::to('portal/question/' . $id);
		}

		$question = Question::findOrfail($id);
		return view('question.show', compact('title', 'question'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/question/' . $id . '/edit');
		}
		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$critical_level = Config::get('constants.EXAM_CRITICAL');
		$answer_list = Config::get('constants.ANSWER_LIST');
		$question = DB::table('questions')
			->join('question_options', 'question_options.questions_questionID', '=', 'questions.questionID')
			->join('class_names', 'class_names.classID', '=', 'questions.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where("questions.questionID", "=", $id)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('question_options.deleted_at')
			->select('questions.*', 'question_options.*', 'branches.branch_name', 'branches.branchID', "class_names.class_name", "class_names.classID")
			->get();
		$question = $question[0];
		//$new_question=$new_option1=$new_option2=$new_option3=$new_option4='';
		//,'old_question','old_option1','old_option2','old_option3','old_option4'

		return view('question.edit', compact('all_branches', 'question', 'const_role_name', "critical_level", "answer_list"));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function update($id, Request $request) {
		/*echo '<pre>';
				print_r($request->all()); exit;*/

		$status = false;
		$input = $request->except('_token');
		/*$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'chapters_chapterID.required' => 'This chapter is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
			'subjects_subjectID.required' => 'The subject field is required.'
		];
		$validation_rule = Validator::make($request->all(), [
			'subjects_subjectID' => 'required',
			'chapters_chapterID' => 'required',
			'class_names_classID' => 'required',
			//'question' => 'required|unique:questions',
			'mark' => 'required',
			'critical_level' => 'required',
			'branches_branchID' => 'required',
			'critical_level' => 'required',
			'option1' => 'required',
			'option2' => 'required',
			'option3' => 'required',
			'option4' => 'required',
			'answer' => 'required',

		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {*/


		$question = Question::findOrfail($id);


		$question->subjects_subjectID = $request->subjects_subjectID;


		$question->chapters_chapterID = $request->chapters_chapterID;

		$question->syllabuses_syllabuseID = 1;


		$question->class_names_classID = $request->class_names_classID;


		$is_img_question = false;
		if (!empty($request->question) && $request->image_question_edit == 'yes') {
			$question->question = $request->question;
			$question->is_image = "no";
		} elseif (!empty($input['image_question']) && $request->image_question_edit == 'yes') {
			$is_img_question = true;
			$question->is_image = "yes";
		}
		$question->mark = $request->mark;
		$question->critical_level = $request->critical_level;
		$status = $question->save();
		if ($status) {
			$status = false;
			$question_options = QuestionOption::where('questions_questionID', $id)->first();
			$question_options->questions_questionID = $id;

			$question_options->answer = $request->answer;
			$question_options->notes = $request->notes;
			$status = $question_options->save();
			if ($status) {

				if ($is_img_question) {
					if ($request->hasFile('image_question')) {
						$file = Input::file('image_question');

						$filename = $file->getClientOriginalName();
						$destinationPath = public_path() . "/questions/" . $id . '/';
						$file->move($destinationPath, $filename);

						$_question = Question::findOrfail($id);
						$_question->question = "/questions/" . $id . '/' . $filename;
						$_question->is_image = "yes";
						$_question->save();
					}
				}

				$update = [];
				for ($ii = 1; $ii <= 4; $ii++) {


					$filename = "option" . $ii . "_image";

					if ($request->hasFile($filename)) {

						$file = Input::file('option' . $ii . '_image');
						$filename = $file->getClientOriginalName();
						$destinationPath = public_path() . "/questions/" . $id . '/';
						$file->move($destinationPath, $filename);
						$update['is_option' . $ii . '_image'] = 'yes';
						$update['option' . $ii] = "/questions/" . $id . '/' . $filename;
					} else {
						$question_options->option4 = $request->{"option$ii"};
						$update["option" . $ii] = $request->{"option$ii"};
						$update['is_option' . $ii . '_image'] = 'no';

					}

				}

				if (count($update) > 0) {

					DB::table('question_options')
						->where('questions_questionID', $id)
						->update($update);
				}

				Session::flash('status', 'The New Subject created Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}


		//}


		return redirect('portal/question');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/question/' . $id . '/delete');

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
		$question = Question::findOrfail($id);
		$question->delete();
		return URL::to('portal/question');
	}
}
