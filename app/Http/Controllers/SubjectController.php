<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Class_name;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class SubjectController.
 *
 * @author Shiva.P
 *
 */
class SubjectController extends Controller {

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
		$const_role_name = $this->constant['super_admin'];

		if (Session::get('role_name') == $const_role_name) {
			$this->query_operator = '!=';
			$this->field_value = '';
		} else {
			$this->query_operator = '=';
			$this->field_value = Session::get('branch_id');
		}

		$subjects = DB::table('subjects')
			->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->where('class_names.deleted_at', '=', NULL)
			->where('subjects.deleted_at', '=', NULL)
			->select('subjects.*', 'class_names.class_name')
			->get();

		return view('subject.index', compact('subjects', 'const_role_name'));
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
		return view('subject.create', compact('all_branches', 'const_role_name'));
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
			'subject.unique_with' => 'This subject is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_names_classID' => 'required',
			'subject' => 'required|unique_with:subjects,class_names_classID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$subject = new Subject();


			$subject->class_names_classID = $request->class_names_classID;


			$subject->subject = $request->subject;


			$status = $subject->save();
		}
		if ($status) {
			Session::flash('status', 'The New Subject created Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/subject');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {
		$const_role_name = $this->constant['super_admin'];
		if ($request->ajax()) {
			return URL::to('portal/subject/' . $id);
		}

		$subject = Subject::findOrfail($id);
		return view('subject.show', compact('title', 'subject'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/subject/' . $id . '/edit');
		}

		$all_branches = $all_branches=array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$subject = DB::table('subjects')
			->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
			->where('subjects.subjectID', '=', $id)
			->select('subjects.*', 'class_names.class_name', 'class_names.branches_branchID')
			->get();
		$subject = $subject[0];

		return view('subject.edit', compact('all_branches', 'subject', 'const_role_name'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function update($id, Request $request) {
		$status = false;
		$input = $request->except('_token');
		$messages = [
			'class_names_classID.required' => 'The class name field is required.',
			'subject.unique_with' => 'This subject is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_names_classID' => 'required',
			'subject' => 'required|unique_with:subjects,class_names_classID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$subject = Subject::findOrfail($id);

			$subject->class_names_classID = $request->class_names_classID;

			$subject->subject = $request->subject;


			$subject->save();
		}
		if ($status) {
			Session::flash('status', 'The Subject updated Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/subject');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/subject/' . $id . '/delete');

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
		$subject = Subject::findOrfail($id);
		$subject->delete();
		return URL::to('portal/subject');
	}
}
