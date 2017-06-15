<?php

namespace App\Http\Controllers;

use App\Syllabus;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branch;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class BranchController.
 *
 * @author  Shiva.P
 *
 */
class BranchController extends Controller {

	protected $query_operator = '';
	protected $field_value = '';

	public function __construct() {
		$this->middleware('portalUser', ['except' => [ ]]);

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function index() {

		if (Session::get('role_name') == "superAdmin") {
			$this->query_operator = '!=';
			$this->field_value = '';
		} else {
			$this->query_operator = '=';
			$this->field_value = Session::get('branch_id');
		}

				
		$branches = DB::table('branches')
			->join('syllabuses', 'syllabuses.syllabuseID', '=', 'branches.syllabuses_syllabuseID')
			->where('branches.branchID', $this->query_operator, $this->field_value)
			->where('branches.deleted_at', '=', NULL)
			->where('syllabuses.deleted_at', '=', NULL)
			->select('branches.*', 'syllabuses.syllabus')
			->get();


		return view('branch.index', compact('branches'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function create() {
		$syllabus_list = Syllabus::all();
		return view('branch.create', compact('syllabus_list'));
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

		$validation_rule = Validator::make($request->all(), [
			'branch_name' => 'required||unique:branches,branch_name',
			'syllabuses_syllabuseID' => 'required',
			'email' => 'required',
			'contact' => 'required',
			'address' => 'required'
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$branch = new Branch();
			$branch->syllabuses_syllabuseID = $request->syllabuses_syllabuseID;
			$branch->createdby = Session::get('user_id');
			$branch->branch_name = $request->branch_name;
			$branch->email = $request->email;
			$branch->contact = $request->contact;
			$branch->address = $request->address;
			$status=$branch->save();
			if ($status) {
				Session::flash('status', 'The New Branch added Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
			return redirect('portal/branch');
		}
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
			return URL::to('portal/branch/' . $id);
		}

		//$branch = Branch::findOrfail($id);
		$branch = DB::table('branches')
			->join('syllabuses', 'syllabuses.syllabuseID', '=', 'branches.syllabuses_syllabuseID')
			->where('branches.branchID', "=", $id)
			->select('branches.*', 'syllabuses.syllabus')
			->get();
		$branch = $branch[0];
		return view('branch.show', compact('title', 'branch'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/branch/' . $id . '/edit');
		}
		$syllabus_list = Syllabus::all();

		$branch = Branch::findOrfail($id);
		return view('branch.edit', compact('syllabus_list', 'branch'));
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

		$validation_rule = Validator::make($request->all(), [
			'branch_name' => 'required||unique:branches,branch_name',
			'syllabuses_syllabuseID' => 'required',
			'email' => 'required',
			'contact' => 'required',
			'address' => 'required'
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$branch = Branch::findOrfail($id);

			$branch->syllabuses_syllabuseID = $request->syllabuses_syllabuseID;
			$branch->createdby = Session::get('user_id');;
			$branch->branch_name = $request->branch_name;
			$branch->email = $request->email;
			$branch->contact = $request->contact;
			$branch->address = $request->address;
			$branch->save();
			if ($status) {
				Session::flash('status', 'The Branch has been updated Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
			return redirect('portal/branch');
		}
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/branch/' . $id . '/delete');

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
		$branch = Branch::findOrfail($id);
		$branch->delete();
		return URL::to('portal/branch');
	}
}
