<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Chapter;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class ChapterController.
 *
 * @author  The scaffold-interface created at 2017-05-25 03:20:11pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class ChapterController extends Controller
{

  protected $query_operator = '';
  protected $field_value = '';
  protected $constant = array();

  public function __construct()
  {
    $this->middleware('portalUser', ['except' => []]);
    $this->constant = Config::get('constants.DEFAULT_DATA');
  }

  /**
   * Display a listing of the resource.
   *
   * @return  \Illuminate\Http\Response
   */
  public function index()
  {
    $const_role_name = $this->constant['super_admin'];
    if (Session::get('role_name') == $const_role_name) {
      $this->query_operator = '!=';
      $this->field_value = '';
    } else {
      $this->query_operator = '=';
      $this->field_value = Session::get('branch_id');
    }

    $chapters = DB::table('chapters')
      ->join('subjects', 'subjects.subjectID', '=', 'chapters.subjects_subjectID')
      ->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
      ->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
      ->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
      ->whereNull('branches.deleted_at')
      ->whereNull('class_names.deleted_at')
      ->whereNull('subjects.deleted_at')
      ->whereNull('chapters.deleted_at')
      ->select('chapters.*', 'branches.branch_name', 'subjects.subject', 'branches.branchID', "class_names.class_name", "class_names.classID")
      ->orderBy("branches.branchID")
      ->get();


    return view('chapter.index', compact('chapters', 'const_role_name'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return  \Illuminate\Http\Response
   */
  public function create()
  {
    $all_branches = array();
    $const_role_name = $this->constant['super_admin'];
    if (Session::get('role_name') == $const_role_name) {
      $all_branches = Branch::all();
    }
    return view('chapter.create', compact('const_role_name', 'all_branches'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param    \Illuminate\Http\Request $request
   * @return  \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $status = false;
    $input = $request->except('_token');
    $messages = [
      'class_names_classID.required' => 'The class name field is required.',
      'chapter.unique_with' => 'This chapter is already exists',
      'branches_branchID.required' => 'The branch name field is required.',
      'subjects_subjectID.required' => 'The subject field is required.'
    ];
    $validation_rule = Validator::make($request->all(), [
      'chapter' => 'required|unique_with:chapters,subjects_subjectID',
      'branches_branchID' => 'required',
      'class_names_classID' => 'required',
      'subjects_subjectID' => 'required',

    ], $messages);


    if ($validation_rule->fails()) {
      return redirect()->back()->withInput()->withErrors($validation_rule->errors());
    } else {
      $chapter = new Chapter();
      $chapter->subjects_subjectID = $request->subjects_subjectID;
      $chapter->chapter = $request->chapter;
      $status = $chapter->save();
    }
    if ($status) {
      Session::flash('status', 'The New Subject created Successfully');
    } else {
      Session::flash('status', 'OOPS! Something went wrong. Please try again');
    }
    return redirect('portal/chapter');
  }

  /**
   * Display the specified resource.
   *
   * @param    \Illuminate\Http\Request $request
   * @param    int $id
   * @return  \Illuminate\Http\Response
   */
  public function show($id, Request $request)
  {
    $title = 'Show - chapter';

    if ($request->ajax()) {
      return URL::to('portal/chapter/' . $id);
    }

    $chapter = Chapter::findOrfail($id);
    return view('chapter.show', compact('title', 'chapter'));
  }

  /**
   * Show the form for editing the specified resource.
   * @param    \Illuminate\Http\Request $request
   * @param    int $id
   * @return  \Illuminate\Http\Response
   */
  public function edit($id, Request $request)
  {

    if ($request->ajax()) {
      return URL::to('portal/chapter/' . $id . '/edit');
    }
    $all_branches = array();
    $const_role_name = $this->constant['super_admin'];
    if (Session::get('role_name') == $const_role_name) {
      $all_branches = Branch::all();
    }

    $chapter = DB::table('chapters')
      ->join('subjects', 'subjects.subjectID', '=', 'chapters.subjects_subjectID')
      ->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
      ->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
      ->where('chapters.chapterID', '=', $id)
      ->whereNull('branches.deleted_at')
      ->whereNull('class_names.deleted_at')
      ->whereNull('subjects.deleted_at')
      ->select('chapters.*', 'branches.branch_name', 'subjects.subject', 'branches.branchID', "class_names.class_name", "class_names.classID")
      ->orderBy("branches.branchID")
      ->get();
    $chapter = $chapter[0];

    return view('chapter.edit', compact('all_branches', 'chapter', 'const_role_name'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param    \Illuminate\Http\Request $request
   * @param    int $id
   * @return  \Illuminate\Http\Response
   */
  public function update($id, Request $request)
  {
    $status = false;
    $input = $request->except('_token');
    $messages = [
      'class_names_classID.required' => 'The class name field is required.',
      'chapter.unique_with' => 'This chapter is already exists',
      'branches_branchID.required' => 'The branch name field is required.',
      'subjects_subjectID.required' => 'The subject field is required.'
    ];
    $validation_rule = Validator::make($request->all(), [
      'chapter' => 'required|unique_with:chapters,subjects_subjectID',
      'branches_branchID' => 'required',
      'class_names_classID' => 'required',
      'subjects_subjectID' => 'required',

    ], $messages);


    if ($validation_rule->fails()) {
      return redirect()->back()->withInput()->withErrors($validation_rule->errors());
    } else {
      $chapter = Chapter::findOrfail($id);

      $chapter->subjects_subjectID = $request->subjects_subjectID;

      $chapter->chapter = $request->chapter;


      $status = $chapter->save();
    }
    if ($status) {
      Session::flash('status', 'The chapter updated Successfully');
    } else {
      Session::flash('status', 'OOPS! Something went wrong. Please try again');
    }

    return redirect('portal/chapter');
  }

  /**
   * Delete confirmation message by Ajaxis.
   *
   * @link      https://github.com/amranidev/ajaxis
   * @param    \Illuminate\Http\Request $request
   * @return  String
   */
  public function DeleteMsg($id, Request $request)
  {
    $msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/chapter/' . $id . '/delete');

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
  public
  function destroy($id)
  {
    $chapter = Chapter::findOrfail($id);
    $chapter->delete();
    return URL::to('portal/chapter');
  }
}
