<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Class_name;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class Class_nameController.
 *
 * @author  Shiva.P
 *
 */
class Class_nameController extends Controller {
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

		//$results = Class_name::with('branch')->get();
		$class_names = DB::table('class_names')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->where('branches.deleted_at', '=', NULL)
			->where('class_names.deleted_at', '=', NULL)
			->select('class_names.*', 'branches.branch_name')
			->get();

		return view('class_name.index', compact('class_names', 'const_role_name'));
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
		return view('class_name.create', compact('all_branches', 'const_role_name'));
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
			'branches_branchID.required' => 'The  branch name field is required.',
			'class_name.unique_with' => 'This class is already exists in the branch',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_name' => 'required|unique_with:class_names,branches_branchID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$class_name = new Class_name();
			$class_name->branches_branchID = $request->branches_branchID;
			$class_name->class_name = $request->class_name;
			$status = $class_name->save();
		}
		if ($status) {
			Session::flash('status', 'The New Class created Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/class');
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
			return URL::to('portal/class/' . $id);
		}

		$class_name = Class_name::findOrfail($id);
		return view('class_name.show', compact('title', 'class_name'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/class/' . $id . '/edit');
		}

		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}
		$class_name = Class_name::findOrfail($id);
		return view('class_name.edit', compact('const_role_name', 'class_name', 'all_branches'));
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
			'branches_branchID.required' => 'The  branch name field is required.',
			'class_name.unique_with' => 'This class is already exists in the branch',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_name' => 'required|unique_with:class_names,branches_branchID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$class_name = Class_name::findOrfail($id);

			$class_name->branches_branchID = $request->branches_branchID;

			$class_name->class_name = $request->class_name;


			$status = $class_name->save();
		}
		if ($status) {
			Session::flash('status', 'The Class details has been updated Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/class');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/class/' . $id . '/delete');

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
		$class_name = Class_name::findOrfail($id);
		$class_name->delete();
		return URL::to('portal/class');
	}
}
