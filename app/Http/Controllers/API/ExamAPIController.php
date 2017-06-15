<?php

namespace App\Http\Controllers\API;

use App\Chapter;
use App\Exam;
use App\ExamResult;
use App\Http\Controllers\Controller;
use App\Question;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class ExamController
 * @package App\Http\Controllers\API
 */
class ExamAPIController extends Controller {

	public function __construct() {
		$this->constant = Config::get('constants.DEFAULT_DATA');
	}

	public function get_all_exams(Request $request) {
		$input = $request->all();
		$user_id = $input['user_id'];
		$branch_id = $input['branch_id'];
		if ($branch_id && $user_id) {
			$const_teach_role = $this->constant['teacher'];
			$const_student_role = $this->constant['student'];
			$const_admin_role = $this->constant['admin'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {
				$result = $user_data[0];
				$result_cpy = json_decode($result);
				$class_list = $subject_list = $section_list = array();
				foreach ($result_cpy->class_has_users as $data) {
					$class_list[] = $data->classID;
				}
				unset($data);


				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}

				if ($cur_role == $const_student_role) {
					$exam_data = Exam::where("branches_branchID", $branch_id)->whereIn("class_names_classID", $class_list)->with('branch', 'className')
						->whereNotIn('examID', function ($query) use ($user_id) {
							$query->select('exam_results.exams_examID')
								->from('exam_results')
								->where('studentID', '=', $user_id);
						})
						->where("is_active",'true')
						->orderBy('exam_date')
						->get();
				}
				if ($cur_role == $const_teach_role) {
					$exam_data = Exam::where("branches_branchID", $branch_id)->whereIn("class_names_classID", $class_list)->with('branch', 'className')
						->whereNotIn('examID', function ($query) {
							$query->select('exam_results.exams_examID')
								->from('exam_results')
								->where('exams_examID', '=', 'exams.examID');
						})
						->where("is_active",'true')
						->orderBy('exam_date')
						->get();
				}

				if ($cur_role == $const_admin_role) {
					$exam_data = Exam::where("branches_branchID", $branch_id)->with('branch', 'className')
						->where("is_active",'true')
						->orderBy('exam_date')
						->get();
				}

				$exam_data = json_decode($exam_data);
				if (count($exam_data) > 0) {

					/** getting all subjects and chapters**/

					$subject_list = DB::table('subjects')->whereIN('subjects.class_names_classID', $class_list)->get();
					$subject_ids = $this->data_filter($subject_list, "subjectID");
					$chapter_list = Chapter::whereIN('subjects_subjectID', $subject_ids)->get();

					/** formatting the return data**/
					$exam_list = array();
					foreach ($exam_data as $exam) {
						$temp = array();
						$no_of_questions = explode(",", $exam->questions);
						$temp = array(
							"examID" => $exam->examID,
							"exam_manualID" => $exam->exam_manualID,
							"class" => $exam->class_name->class_name,
							"class_id" => $exam->class_names_classID,
							"title" => $exam->title,
							"duration" => $exam->duration,
							"exam_status" => $exam->is_active,
							"number_of_questions" => count($no_of_questions),
							"total_marks" => $exam->total_marks,
							"topics_covered" => $exam->chapterIDS,
							"exam_date" => $exam->exam_date,
							"usernote" => $exam->note,
							"subjects" => $this->custom_filer($subject_list, "subjectID", $exam->subjectIDS),
							"chapters" => $this->custom_filer($chapter_list, "chapterID", $exam->chapterIDS)

						);
						$exam_list[] = $temp;
					}
					unset($exam);
					unset($temp);
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array($exam_list, TRUE, NULL, NULL);
					return response(array(array_combine($keys, $values)), 200);
				} else {
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(NULL, FALSE, "404", "No Exams Found");
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(NULL, FALSE, "404", "No Exams Found");
				return response(array(array_combine($keys, $values)), 404);
			}

		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '403', "Expecting the Branch ID and User ID, it's not present ");
			return response(array(array_combine($keys, $values)), 404);
		}

	}


	public function enable_exam(Request $request) {
		$input = $request->all();
		$user_id = $input['user_id'];
		$branch_id = $input['branch_id'];
		$exam_id = $input['exam_id'];
		if ($branch_id && $user_id && $exam_id && is_numeric($exam_id)) {

			$const_teach_role = $this->constant['teacher'];
			$const_admin_role = $this->constant['admin'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {
				$result = $user_data[0];

				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}

				if ($cur_role == $const_admin_role || $cur_role == $const_teach_role) {
					$status = DB::table('exams')
						->where('examID', $exam_id)
						->update(['is_active' => 'true']);
					if ($status) {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(true, NULL, NULL);
					} else {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(false, '404', "Oops!. Something went wrong. Please contact the admin ");
					}
					return response(array(array_combine($keys, $values)), 404);
				} else {
					$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(false, '404', "INVALID arguments passed / NO data found");
					return response(array(array_combine($keys, $values)), 404);
				}

			}

		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "INVALID arguments passed ");
			return response(array(array_combine($keys, $values)), 404);
		}
	}


	public function disable_exam(Request $request) {
		$input = $request->all();
		$user_id = $input['user_id'];
		$branch_id = $input['branch_id'];
		$exam_id = $input['exam_id'];
		if ($branch_id && $user_id && $exam_id && is_numeric($exam_id)) {

			$const_teach_role = $this->constant['teacher'];
			$const_admin_role = $this->constant['admin'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {
				$result = $user_data[0];

				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}

				if ($cur_role == $const_admin_role || $cur_role == $const_teach_role) {
					$status = DB::table('exams')
						->where('examID', $exam_id)
						->update(['is_active' => 'false']);
					if ($status) {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(true, NULL, NULL);
					} else {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(false, '404', "Oops!. Something went wrong. Please contact the admin ");
					}
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "INVALID arguments passed / NO data found ");
				return response(array(array_combine($keys, $values)), 404);
			}

		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "INVALID arguments passed ");
			return response(array(array_combine($keys, $values)), 404);
		}
	}

	public function delete_exam(Request $request) {

		/**TO-DO: Need to check anything based on the date before delete**/
		$input = $request->all();
		$user_id = $input['user_id'];
		$exam_id = $input['exam_id'];
		if ($user_id && $exam_id && is_numeric($exam_id)) {

			$const_teach_role = $this->constant['teacher'];
			$const_admin_role = $this->constant['admin'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {
				$result = $user_data[0];

				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}


				if ($cur_role == $const_admin_role || $cur_role == $const_teach_role) {

					$exam_obj = Exam::findOrfail($exam_id);
					$status = $exam_obj->delete();

					if ($status) {

						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(true, '200', "The exam deleted successfully");
						return response(array(array_combine($keys, $values)), 200);
					} else {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(false, '404', "Internal server error ");
						return response(array(array_combine($keys, $values)), 404);
					}


				} else {
					$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(false, '404', "Permission Denied");
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "Invalid arguments passed / No Data found");
				return response(array(array_combine($keys, $values)), 404);
			}

		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "Invalid arguments passed");
			return response(array(array_combine($keys, $values)), 404);
		}
	}


	/** Questions for students **/
	public function getQuestions(Request $request) {
		$input = $request->all();
		$exam_id = $input['exam_id'];
		if ($exam_id) {
			$exam = Exam::where("exam_manualID", $exam_id)->get();
			$exam_data = json_decode($exam);

			if (count($exam_data) > 0) {
				if (isset($exam_data[0]->is_active) && $exam_data[0]->is_active == "true") {
					$exam_data = $exam_data[0];
					$question = $exam_data->questions;
					$question_ids = explode(",", $question);

					$question_list = DB::table('questions')
						->join('question_options', 'question_options.questions_questionID', '=', 'questions.questionID')
						->whereIn("questionID", $question_ids)
						->select('questions.*', 'question_options.*')
						->get();

					$keys = array('QuestionsList', 'Duration', 'TotalMarks', 'ExamTitle', 'NegativeMarks', 'Critical_level', 'isSuccess', 'ErrorCode', 'ErrorMessage');
					$values = array($question_list, $exam_data->duration, $exam_data->total_marks, $exam_data->title, $exam_data->negative_mark, Config::get("constants.EXAM_CRITICAL")[$exam_data->critical_level], TRUE, FALSE, FALSE);
					return response(array(array_combine($keys, $values)), 200);

				} else {
					$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(false, '404', "INVALID Exam ID");
					return response(array(array_combine($keys, $values)), 404);
				}

			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "Invalid arguments passed. /  NO Data found");
				return response(array(array_combine($keys, $values)), 404);
			}
		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "INVALID arguments passed ");
			return response(array(array_combine($keys, $values)), 404);
		}
	}


	public function submitExam(Request $request) {

		//TO-DO: Need to check the time aganist duration and start time

		$input = $request->all();
		$exam_id = $input['exam_id'];
		$total = $input['total'];
		$student_id = $input['student_id'];
		$user_answer_data = $input['user_answer_data'];
		$is_pass = $input['is_pass'];
		if ($exam_id != '' && $total != '' && $student_id != '' && $user_answer_data != '' && $is_pass != '') {
			$exam_result = new ExamResult();
			$exam_result->exams_examID = $exam_id;
			$exam_result->studentID = $student_id;
			$exam_result->total = $total;
			$exam_result->user_answer_data = $user_answer_data;
			$exam_result->is_pass = $is_pass;
			$status = $exam_result->save();
			if ($status) {

				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(true, '200', "The result saved successfully");
				return response(array(array_combine($keys, $values)), 200);
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "Internal server error ");
				return response(array(array_combine($keys, $values)), 404);
			}

		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "INVALID arguments passed ");
			return response(array(array_combine($keys, $values)), 404);
		}

	}


	public function get_exam_history(Request $request) {

		/**TO-DO: Need to check anything based on the date before delete**/
		$input = $request->all();
		$user_id = $input['user_id'];
		$branch_id = $input['branch_id'];
		$cur_user = '';
		if ($branch_id && $user_id) {

			$const_teach_role = $this->constant['teacher'];
			//$const_admin_role = $this->constant['admin'];
			$const_student_role = $this->constant['student'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {

				$result = $user_data[0];
				$result_cpy = json_decode($result);
				$class_list = $subject_list = $section_list = $user_subject_list = array();

				foreach ($result_cpy->class_has_users as $data) {
					$class_list[] = $data->classID;
					$user_subject_list[] = $data->subjectID;
				}
				unset($data);
				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}


				if ($cur_role == $const_student_role) {
					$cur_user = 'student';
					$exam_data = Exam::where("branches_branchID", $branch_id)->whereIn("class_names_classID", $class_list)->with('branch', 'className')
						->whereIn('examID', function ($query) use ($user_id) {
							$query->select('exam_results.exams_examID')
								->from('exam_results')
								->where('studentID', '=', $user_id);
						})
						->orderBy('exam_date')
						->get();
				} elseif ($cur_role == $const_teach_role) {
					$cur_user = 'teacher';
					$exam_data = Exam::where("branches_branchID", $branch_id)->whereIn("class_names_classID", $class_list)->with('branch', 'className')
						->whereIn('examID', function ($query) {
							$query->select('exam_results.exams_examID')
								->from('exam_results');
						})
						->orderBy('exam_date')
						->get();
				} else {
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(NULL, FALSE, "404", "Only Student/Teacher can access");
					return response(array(array_combine($keys, $values)), 200);
				}

				$exam_data = json_decode($exam_data);
				if (count($exam_data) > 0) {

					/** getting all subjects and chapters**/

					$subject_list = DB::table('subjects')->whereIN('subjects.class_names_classID', $class_list)->get();
					$subject_ids = $this->data_filter($subject_list, "subjectID");
					$chapter_list = Chapter::whereIN('subjects_subjectID', $subject_ids)->get();

					/** formatting the return data**/
					$exam_list = array();
					foreach ($exam_data as $exam) {
						$temp = array();
						$no_of_questions = explode(",", $exam->questions);

						$temp = array(
							"examID" => $exam->examID,
							"exam_manualID" => $exam->exam_manualID,
							"class" => $exam->class_name->class_name,
							"class_id" => $exam->class_names_classID,
							"title" => $exam->title,
							"duration" => $exam->duration,
							"exam_status" => $exam->is_active,
							"number_of_questions" => count($no_of_questions),
							"total_marks" => $exam->total_marks,
							"topics_covered" => $exam->chapterIDS,
							"exam_date" => $exam->exam_date,
							"usernote" => $exam->note,
							"subjects" => $this->custom_filer($subject_list, "subjectID", $exam->subjectIDS),
							"chapters" => $this->custom_filer($chapter_list, "chapterID", $exam->chapterIDS)

						);
						if ($cur_user == 'teacher') {
							$res_sub_ = array_intersect($user_subject_list, explode(",", $exam->subjectIDS));
							if (count($res_sub_) > 0) {
								$exam_list[] = $temp;
							}
						}
						if ($cur_user == 'student') {
							$exam_list[] = $temp;
						}

					}
					unset($exam);
					unset($temp);

					if (count($exam_list) > 0) {
						$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
						$values = array($exam_list, TRUE, NULL, NULL);
						return response(array(array_combine($keys, $values)), 200);
					} else {
						$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(NULL, FALSE, "404", "No Exams Found");
						return response(array(array_combine($keys, $values)), 404);
					}
				} else {
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(NULL, FALSE, "404", "No Exams Found");
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "Invalid arguments passed. /  NO Data found");
				return response(array(array_combine($keys, $values)), 404);
			}
		}
	}

	public function get_past_result(Request $request) {

		/**TO-DO: Need to check anything based on the date before delete**/
		$input = $request->all();
		$user_id = $input['student_id'];
		$exam_id = $input['exam_id'];
		$current_user=$input['current_userid'];
		if ($exam_id && $user_id) {

			$const_teach_role = $this->constant['teacher'];
			//$const_admin_role = $this->constant['admin'];
			$const_student_role = $this->constant['student'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {
				$result = $user_data[0];
				$result_cpy = json_decode($result);
				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}
				
				
				
				
				if ($cur_role == $const_student_role || $cur_role == $const_teach_role) {


					$exam_result = ExamResult::with('exam')->where("studentID", $user_id)
						->where('exams_examID', function ($query) use ($exam_id) {
							$query->select('exams.examID')
								->from('exams')
								->where('exam_manualID', '=', $exam_id);
						})
						->get();
					$exam_result = json_decode($exam_result);
					if (count($exam_result) > 0) {
						$exam_result_cpy = $exam_result[0];

						$answer_list = explode(",", $exam_result_cpy->user_answer_data);
						$user_answer_list = array();
						foreach ($answer_list as $answer) {
							$ans_part = explode(":", $answer);
							$user_answer_list[$ans_part[0]] = $ans_part[1];
						}
						unset($answer);


						$class_list = $subject_list = $section_list = array();
						foreach ($result_cpy->class_has_users as $data) {
							$class_list[] = $data->classID;
						}
						unset($data);


						$exam_data = $exam_result_cpy->exam;

						/** getting all subjects and chapters**/

						$subject_list = DB::table('subjects')->whereIN('subjects.class_names_classID', $class_list)->get();
						$subject_ids = $this->data_filter($subject_list, "subjectID");
						$chapter_list = Chapter::whereIN('subjects_subjectID', $subject_ids)->get();


						$question = $exam_data->questions;
						$question_ids = explode(",", $question);

						$question_list = DB::table('questions')
							->join('question_options', 'question_options.questions_questionID', '=', 'questions.questionID')
							->whereIn("questionID", $question_ids)
							->select('questions.*', 'question_options.*')
							->get();

						$question_list = json_decode($question_list);

						foreach ($question_list as $q) {
							$q->user_anser = $user_answer_list[$q->questionID];
						}
						unset($q);

						$this_exam_subjects = $this->custom_filer($subject_list, "subjectID", $exam_data->subjectIDS);
						$this_exam_chapters = $this->custom_filer($chapter_list, "chapterID", $exam_data->chapterIDS);

						$keys = array("exam_manualID", "title", "critical_level", "total_marks", "pass_percentage", "exam_date", "negative_mark", "duration", "note","subjects", "chapters", "question_list", 'isSuccess', 'ErrorCode', 'ErrorMessage');
						$values = array($exam_data->exam_manualID, $exam_data->title, Config::get("constants.EXAM_CRITICAL")[$exam_data->critical_level], $exam_data->total_marks, $exam_data->pass_percentage, $exam_data->exam_date, $exam_data->negative_mark, $exam_data->duration, $exam_data->note,$this_exam_subjects, $this_exam_chapters, $question_list, TRUE, NULL, NULL);
						return response(array(array_combine($keys, $values)), 200);
					} else {
						$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(FALSE, "404", "There is no record for this student");
						return response(array(array_combine($keys, $values)), 404);
					}
				} else {
					$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(FALSE, "404", "No Access for the current user");
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "Invalid arguments passed. /  NO Data found");
				return response(array(array_combine($keys, $values)), 404);
			}
		} else {
			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(FALSE, "404", "Invalid request parameters");
			return response(array(array_combine($keys, $values)), 404);
		}
	}


	public function get_student_exam_history(Request $request) {

		$input = $request->all();
		$user_id = $input['student_id'];
		$branch_id = $input['branch_id'];
		$teacher_id = $input['current_userid'];

		$cur_user = '';
		if ($branch_id && $user_id) {

			$const_teach_role = $this->constant['teacher'];
			//$const_admin_role = $this->constant['admin'];
			$const_student_role = $this->constant['student'];

			$user_data = User::with('role')->with("classHasUsers")->with("branch")->where("userID", $user_id)->get();
			if (count($user_data) > 0) {

				$result = $user_data[0];
				$result_cpy = json_decode($result);
				$class_list = $subject_list = $section_list = $user_subject_list = array();

				foreach ($result_cpy->class_has_users as $data) {
					$class_list[] = $data->classID;
					$user_subject_list[] = $data->subjectID;
				}
				unset($data);
				$cur_role = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $user_id)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;

				} else {
					$cur_role = $result->role->role;
				}


				if ($cur_role == $const_student_role) {
					$cur_user = 'student';
					$exam_data = Exam::where("branches_branchID", $branch_id)->whereIn("class_names_classID", $class_list)->with('branch', 'className')
						->whereIn('examID', function ($query) use ($user_id) {
							$query->select('exam_results.exams_examID')
								->from('exam_results')
								->where('studentID', '=', $user_id);
						})
						->orderBy('exam_date')
						->get();
				} else {
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(NULL, FALSE, "404", "Only Student/Teacher can access");
					return response(array(array_combine($keys, $values)), 404);
				}

				$exam_data = json_decode($exam_data);
				if (count($exam_data) > 0) {

					/** getting all subjects and chapters**/

					$subject_list = DB::table('subjects')->whereIN('subjects.class_names_classID', $class_list)->get();
					$subject_ids = $this->data_filter($subject_list, "subjectID");
					$chapter_list = Chapter::whereIN('subjects_subjectID', $subject_ids)->get();

					/** formatting the return data**/
					$exam_list = array();
					foreach ($exam_data as $exam) {
						$temp = array();
						$no_of_questions = explode(",", $exam->questions);

						$temp = array(
							"examID" => $exam->examID,
							"exam_manualID" => $exam->exam_manualID,
							"class" => $exam->class_name->class_name,
							"class_id" => $exam->class_names_classID,
							"title" => $exam->title,
							"duration" => $exam->duration,
							"exam_status" => $exam->is_active,
							"number_of_questions" => count($no_of_questions),
							"total_marks" => $exam->total_marks,
							"topics_covered" => $exam->chapterIDS,
							"exam_date" => $exam->exam_date,
							"usernote" => $exam->note,
							"subjects" => $this->custom_filer($subject_list, "subjectID", $exam->subjectIDS),
							"chapters" => $this->custom_filer($chapter_list, "chapterID", $exam->chapterIDS)

						);
						$exam_list[] = $temp;


					}
					unset($exam);
					unset($temp);

					if (count($exam_list) > 0) {
						$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
						$values = array($exam_list, TRUE, NULL, NULL);
						return response(array(array_combine($keys, $values)), 200);
					} else {
						$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
						$values = array(NULL, FALSE, "404", "No Exams Found");
						return response(array(array_combine($keys, $values)), 404);
					}
				} else {
					$keys = array('ListOfScheduledExams', 'is_success', 'ErrorCode', 'ErrorMessage');
					$values = array(NULL, FALSE, "404", "No Exams Found");
					return response(array(array_combine($keys, $values)), 404);
				}
			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '405', "Invalid arguments passed. /  NO Data found");
				return response(array(array_combine($keys, $values)), 404);
			}
		}

	}


	/*Common functionality starts here*/
	public function data_filter($mixed_data, $key) {
		$return_data = array();
		$mixed_data_cpy = json_decode($mixed_data);
		foreach ($mixed_data_cpy as $data) {
			$return_data[] = $data->$key;
		}
		unset($data);
		return $return_data;
	}

	public function custom_filer($all_data, $key, $to_filer) {
		$return_data = array();
		$all_data_cpy = json_decode($all_data);
		$to_compare = explode(",", $to_filer);
		foreach ($to_compare as $c_data) {
			foreach ($all_data_cpy as $single) {
				if ($single->$key == $c_data) {
					$return_data[] = $single;
					break;
				}
			}
			unset($single);

		}
		unset($c_data);
		return $return_data;
	}
}