<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class SectionController.
 *
 * @author  The scaffold-interface created at 2017-05-23 03:09:07am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class SectionController extends Controller {
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

		$sections = DB::table('sections')
			->join('class_names', 'class_names.classID', '=', 'sections.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('sections.deleted_at')
			->select('sections.*', 'branches.branch_name', "class_names.class_name")
			->orderBy("branches.branchID")
			->get();

		return view('section.index', compact('sections', 'const_role_name'));
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

		return view('section.create', compact('all_branches', 'const_role_name'));
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
			'section_name.unique_with' => 'This section is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_names_classID' => 'required',
			'section_name' => 'required|unique_with:sections,class_names_classID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$section = new Section();


			$section->class_names_classID = $request->class_names_classID;


			$section->section_name = $request->section_name;


			$status = $section->save();
		}
		if ($status) {
			Session::flash('status', 'The New Section created Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/section');
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
			return URL::to('portal/section/' . $id);
		}


		$section = Section::findOrfail($id);
		return view('section.show', compact('section'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/section/' . $id . '/edit');
		}

		$all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}

		$section = DB::table('sections')
			->join('class_names', 'class_names.classID', '=', 'sections.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where('sections.sectionID', '=', $id)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->select('sections.*', 'branches.branch_name', "class_names.class_name", 'class_names.branches_branchID')
			->get();
		$section = $section[0];

		return view('section.edit', compact('all_branches', 'section', 'const_role_name'));
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
			'section_name.unique_with' => 'This section is already exists',
			'branches_branchID.required' => 'The branch name field is required.',
		];
		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_names_classID' => 'required',
			'section_name' => 'required|unique_with:sections,class_names_classID'
		], $messages);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$section = Section::findOrfail($id);

			$section->class_names_classID = $request->class_names_classID;

			$section->section_name = $request->section_name;


			$status = $section->save();
		}
		if ($status) {
			Session::flash('status', 'The Section updated Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}

		return redirect('portal/section');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/section/' . $id . '/delete');

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
		$section = Section::findOrfail($id);
		$section->delete();
		return URL::to('portal/section');
	}
}
