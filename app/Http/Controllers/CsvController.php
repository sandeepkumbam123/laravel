<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Question;
use App\QuestionOption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class CsvController extends Controller
{
  protected $query_operator = '';
  protected $field_value = '';
  protected $constant = array();
  protected $csv_location = '/csv/';

  public function __construct()
  {
    $this->middleware('portalUser', ['except' => []]);
    $this->constant = Config::get('constants.DEFAULT_DATA');
  }

  public function index()
  {

    $critical_level = Config::get('constants.EXAM_CRITICAL');
    $const_role_name = $this->constant['super_admin'];

    $all_branches = array();

    if (Session::get('role_name') == $const_role_name) {
      $all_branches = Branch::all();
    }
    $answer_list = Config::get('constants.ANSWER_LIST');
    return view('csv.question', compact('all_branches', 'const_role_name', 'critical_level', 'answer_list'));


  }

  public function storeQuestions(Request $request)
  {
    $failed_rows = array();
    $input = $request->except('_token');
    $messages = [
      'class_names_classID.required' => 'The class name field is required.',
      'chapters_chapterID.required' => 'This chapter is already exists',
      'branches_branchID.required' => 'The branch name field is required.',
      'subjects_subjectID.required' => 'The subject field is required.',

    ];
    $validation_rule = Validator::make($request->all(), [
      'subjects_subjectID' => 'required',
      'chapters_chapterID' => 'required',
      'class_names_classID' => 'required',
      'branches_branchID' => 'required',
      'csvFile' => 'required',
    ], $messages);


    if ($validation_rule->fails()) {
      return redirect()->back()->withInput()->withErrors($validation_rule->errors());
    } else {
//Session::get('user_id');

      if ($request->hasFile('csvFile')) {

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
                $question->subjects_subjectID = $request->subjects_subjectID;
                $question->chapters_chapterID = $request->chapters_chapterID;
                $question->syllabuses_syllabuseID = 1;
                $question->class_names_classID = $request->class_names_classID;
                $question->question = $row[0];
                $question->mark = $row[5];;
                $question->critical_level = $row[6];;
                $question->is_image = "no";
                $question->save();


                $question_options = new QuestionOption();
                $question_options->questions_questionID = $question->questionID;
                $question_options->option1 = $row[1];
                $question_options->option2 = $row[2];
                $question_options->option3 = $row[3];
                $question_options->option4 = $row[4];
                $question_options->answer = $row[7];
                //$question_options->notes = $row[8];
                $status = $question_options->save();
                if ($status) {
                  $total += 1;
                }

              } catch (QueryException $e) {
                $failed_rows[] = $ii;
              }
            }

            $ii += 1;
          }
        }

        $critical_level = Config::get('constants.EXAM_CRITICAL');
        $const_role_name = $this->constant['super_admin'];

        $all_branches = array();

        if (Session::get('role_name') == $const_role_name) {
          $all_branches = Branch::all();
        }
        $answer_list = Config::get('constants.ANSWER_LIST');
        return view('csv.question', compact('all_branches', 'const_role_name', 'critical_level', 'answer_list', 'failed_rows', 'total'));

      }
    }

  }
}
