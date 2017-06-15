<?php

namespace App\Http\Controllers;

use Amranidev\Ajaxis\Ajaxis;
use App\Branch;
use App\Class_name;
use App\ClassesHasUsers;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller {
	protected $query_operator = '';
	protected $field_value = '';
	protected $constant = array();
	protected $pro_pic_location = "/users/";
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


		$users = DB::table('users')
			->join('branches', 'branches.branchID', '=', 'users.branchID')
			//->join('classes_has_users', 'classes_has_users.userID', '=', 'users.userID')
			//->join('class_names', 'class_names.classID', '=', 'classes_has_users.classID')
			->where('users.roles_roleID', '=', 3)
			->where('users.branchID', $this->query_operator, $this->field_value)
			//->where('class_names.deleted_at', '=', NULL)
			->where('branches.deleted_at', '=', NULL)
			//->where('classes_has_users.deleted_at', '=', NULL)
			->where('users.deleted_at', '=', NULL)
			->select('users.*', 'branches.branch_name')
			->get();


		return view('teacher.index', compact('users', 'const_role_name'));
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
		return view('teacher.create', compact('all_branches', 'const_role_name'));
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
			'branches_branchID' => 'required',
			'user_name' => 'required|unique:users,user_name',
			'first_name' => 'required',
			'last_name' => 'required',
			'email_id' => 'required|unique:users,email_id',
			'password' => 'required',
			'mobile' => 'required',
			'dob' => 'required',
			'profile_pic' => 'required',
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {

			$user = new User();

			$user->branchID = $request->branches_branchID;

			$user->roles_roleID = 3;

			$user->reg_number = time();


			$user->user_name = $request->user_name;


			$user->first_name = $request->first_name;


			$user->last_name = $request->last_name;


			$user->email_id = $request->email_id;


			$user->password = bcrypt($request->password);


			$user->mobile = $request->mobile;


			$user->dob = $request->dob;


			$d1 = new DateTime(date("Y-m-d", strtotime(str_replace("-", "/", $request->dob))));
			$d2 = new DateTime(date('Y-m-d'));
			$diff = $d2->diff($d1);
			$user->age = $diff->y;


			$status = $user->save();

			if ($status) {
				if ($request->hasFile('profile_pic')) {
					$file = Input::file('profile_pic');
					$filename = $file->getClientOriginalName();
					$destinationPath = public_path() . "/teacher/profile_pics/" . $request->branches_branchID . '/';
					$file->move($destinationPath, $filename);
					$_user = User::findOrfail($user->userID);
					$_user->profile_pic = "/teacher/profile_pics/" . $request->branches_branchID . '/' . $filename;
					$_user->save();
				}

				Session::flash('status', 'The New Student created Successfully');
			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}


		return redirect('portal/teacher');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {
		$title = 'Show - user';

		if ($request->ajax()) {
			return URL::to('portal/user/' . $id);
		}

		$user = User::findOrfail($id);
		return view('user.show', compact('title', 'user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/teacher/' . $id . '/edit');
		}

		$all_branches = $all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}

		$user = DB::table('users')
			->join('branches', 'branches.branchID', '=', 'users.branchID')
			->where('users.userID', '=', $id)
			->where('branches.deleted_at', '=', NULL)
			->where('users.deleted_at', '=', NULL)
			->select('users.*', 'branches.*')
			->get();
		$user = $user[0];

		return view('teacher.edit', compact('all_branches', 'user', 'const_role_name'));
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

		$rules = [
			'branches_branchID' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'mobile' => 'required',
			'dob' => 'required',
		];

		if (!(isset($input['is_new_image']) && $input['is_new_image'] == 'no')) {

			$rules['new_image'] = 'required';
		}


		if ($input['user_name'] != $input['old_user_name']) {
			$rules['user_name'] = 'required|unique:users,user_name';
		}

		if ($input['email_id'] != $input['old_email_id']) {
			$rules['email_id'] = 'required|unique:users,email_id';
		}

		$validation_rule = Validator::make($request->all(), $rules);
		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$user = User::findOrfail($id);

			$user->branchID = $request->branches_branchID;


			$user->roles_roleID = 3;


			$user->user_name = $request->user_name;


			$user->first_name = $request->first_name;


			$user->last_name = $request->last_name;


			$user->email_id = $request->email_id;

			if ($request->new_password) {
				$user->password = bcrypt($request->new_password);
			}


			$user->mobile = $request->mobile;


			$user->dob = $request->dob;


			$d1 = new DateTime(date("Y-m-d", strtotime(str_replace("-", "/", $request->dob))));
			$d2 = new DateTime(date('Y-m-d'));
			$diff = $d2->diff($d1);

			$user->age = $diff->y;


			$status = $user->save();

			if ($status) {


				if ($request->hasFile('new_image')) {
					$file = Input::file('new_image');

					$filename = $file->getClientOriginalName();
					$destinationPath = public_path() . "/teacher/profile_pics/" . $request->branches_branchID . '/';
					$file->move($destinationPath, $filename);

					$_user = User::findOrfail($id);
					$_user->profile_pic = "/teacher/profile_pics/" . $request->branches_branchID . '/' . $filename;
					$_user->save();
				}

				Session::flash('status', 'The New Student created Successfully');


			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}


		}
		return redirect('portal/teacher');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/teacher/' . $id . '/delete');

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
		$user = User::findOrfail($id);
		$user->delete();
		return URL::to('portal/teacher');
	}

	public function getRolesList($id) {

		$roles = DB::table('classes_has_users')
			->join('subjects', 'subjects.subjectID', '=', 'classes_has_users.subjectID')
			->join('sections', 'sections.sectionID', '=', 'classes_has_users.sectionID')
			->join('class_names', 'class_names.classID', '=', 'classes_has_users.classID')
			->join('users', 'users.userID', '=', 'classes_has_users.userID')
			->where('classes_has_users.userID', '=', $id)
			->where('class_names.deleted_at', '=', NULL)
			->where('subjects.deleted_at', '=', NULL)
			->where('sections.deleted_at', '=', NULL)
			->where('classes_has_users.deleted_at', '=', NULL)
			->select('classes_has_users.*', 'class_names.*', 'sections.*', 'subjects.*', 'users.user_name')
			->get();
		if (count($roles) > 0) {
			return view('teacher.role_index', compact('roles', 'id'));
		} else {
			return redirect()->action('TeacherController@index');

		}
	}

	public function showAddRole_form($id) {
		$user_data = DB::table('users')->where('userID', $id)->first();
		$class_list = Class_name::where('branches_branchID', '=', $user_data->branchID)->get();
		$branch_id = $user_data->branchID;
		return view('teacher.add_role', compact('id', 'class_list', 'branch_id'));
	}

	public function saveRole(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$validation_rule = Validator::make($request->all(), [
			'userID' => 'required',
			'classID' => 'required',
			'sectionID' => 'required',
			'subjectID' => 'required',
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {
			$is_valid = ClassesHasUsers::where('userID', $request->userID)
				->where('classID', $request->classID)
				->where('sectionID', $request->sectionID)
				->where('subjectID', $request->subjectID)
				->count();
			if ($is_valid) {
				return redirect()->back()->withInput()->withErrors(['is_valid' => "There is a teacher for this class subject"]);

			} else {

				$class_user = new ClassesHasUsers();
				$class_user->userID = $request->userID;
				$class_user->classID = $request->classID;
				$class_user->sectionID = $request->sectionID;
				$class_user->subjectID = $request->subjectID;
				$status = $class_user->save();
				if ($status) {
					Session::flash('status', 'The New Role created Successfully');
				} else {
					Session::flash('status', 'OOPS! Something went wrong. Please try again');
				}
			}
		}
		return redirect('portal/teacher/' . $request->userID . '/roles');
	}


	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteRoleMsg($id, $userID, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/role/' . $id . '/deleteRole/' . $userID);

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
	public function destroyRole($id, $userID) {

		DB::delete('delete from classes_has_users where id=' . $id);
		return URL::to('portal/teacher/' . $userID . "/roles");
		//return URL::to('portal/teacher/');
	}
}
