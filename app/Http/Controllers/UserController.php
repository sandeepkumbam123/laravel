<?php

namespace App\Http\Controllers;

use App\Branch;
use App\ClassesHasUsers;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;
use League\Csv\Reader;

/**
 * Class UserController.
 *
 * @author  The scaffold-interface created at 2017-06-04 01:37:37pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class UserController extends Controller {

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
			->join('classes_has_users', 'classes_has_users.userID', '=', 'users.userID')
			->join('class_names', 'class_names.classID', '=', 'classes_has_users.classID')
			->where('users.roles_roleID', '=', 4)
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->where('class_names.deleted_at', '=', NULL)
			->where('branches.deleted_at', '=', NULL)
			->where('classes_has_users.deleted_at', '=', NULL)
			->where('users.deleted_at', '=', NULL)
			->select('users.*', 'class_names.class_name', 'branches.branch_name')
			->get();


		return view('user.index', compact('users', 'const_role_name'));
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
		return view('user.create', compact('all_branches', 'const_role_name'));
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
			'class_names_classID' => 'required',
			'sectionID' => 'required',
			'reg_number' => 'required|unique:users,reg_number',
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

			$user->roles_roleID = 4;


			$user->reg_number = $request->reg_number;


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
				$status = false;
				$userID = $user->userID;
				$ClassesHasUsers = new ClassesHasUsers();
				$ClassesHasUsers->userID = $userID;
				$ClassesHasUsers->classID = $request->class_names_classID;
				$ClassesHasUsers->sectionID = $request->sectionID;
				$status = $ClassesHasUsers->save();

				if ($status) {
					if ($request->hasFile('profile_pic')) {
						$file = Input::file('profile_pic');

						$filename = $file->getClientOriginalName();
						$destinationPath = public_path() . "/users/profile_pics/" . $request->class_names_classID . '/';
						$file->move($destinationPath, $filename);

						$_user = User::findOrfail($userID);
						$_user->profile_pic = "/users/profile_pics/" . $request->class_names_classID . '/' . $filename;
						$_user->save();
					}

					Session::flash('status', 'The New Student created Successfully');
				} else {
					Session::flash('status', 'OOPS! Something went wrong. Please try again');
				}

			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}
		}


		return redirect('portal/user');
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
			return URL::to('portal/user/' . $id . '/edit');
		}

		$all_branches = $all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}

		$user = DB::table('users')
			->join('branches', 'branches.branchID', '=', 'users.branchID')
			->join('classes_has_users', 'classes_has_users.userID', '=', 'users.userID')
			->join('class_names', 'class_names.classID', '=', 'classes_has_users.classID')
			->where('users.userID', '=', $id)
			->where('class_names.deleted_at', '=', NULL)
			->where('branches.deleted_at', '=', NULL)
			->where('classes_has_users.deleted_at', '=', NULL)
			->where('users.deleted_at', '=', NULL)
			->select('users.*', 'class_names.*', 'classes_has_users.*', 'branches.*')
			->get();
		$user = $user[0];

		return view('user.edit', compact('all_branches', 'user', 'const_role_name'));
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
			'class_names_classID' => 'required',
			'sectionID' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'mobile' => 'required',
			'dob' => 'required',
		];

		if (!(isset($input['is_new_image']) && $input['is_new_image'] == 'no')) {

			$rules['new_image'] = 'required';
		}
		if ($input['reg_number'] != $input['old_reg_number']) {
			$rules['reg_number'] = 'required|unique:users,reg_number';
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


			$user->roles_roleID = 4;


			$user->reg_number = $request->reg_number;


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
				$status = false;
				$userID = $id;
				DB::table('classes_has_users')->where('userID', '=', $id)->delete();

				$ClassesHasUsers = new ClassesHasUsers();
				$ClassesHasUsers->userID = $userID;
				$ClassesHasUsers->classID = $request->class_names_classID;
				$ClassesHasUsers->sectionID = $request->sectionID;
				$status = $ClassesHasUsers->save();

				if ($status) {
					if ($request->hasFile('new_image')) {
						$file = Input::file('new_image');

						$filename = $file->getClientOriginalName();
						$destinationPath = public_path() . "/users/profile_pics/" . $request->class_names_classID . '/';
						$file->move($destinationPath, $filename);

						$_user = User::findOrfail($userID);
						$_user->profile_pic = "/users/profile_pics/" . $request->class_names_classID . '/' . $filename;
						$_user->save();
					}

					Session::flash('status', 'The New Student created Successfully');
				} else {
					Session::flash('status', 'OOPS! Something went wrong. Please try again');
				}

			} else {
				Session::flash('status', 'OOPS! Something went wrong. Please try again');
			}


		}
		return redirect('portal/user');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/user/' . $id . '/delete');

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
		return URL::to('portal/user');
	}


	public function show_upload_form() {
		$all_branches = $all_branches = array();
		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$all_branches = Branch::all();
		}

		return view('user.upload_form', compact('all_branches', 'const_role_name'));
	}

	public function upload_user(Request $request) {
		$status = false;
		$input = $request->except('_token');

		$validation_rule = Validator::make($request->all(), [
			'branches_branchID' => 'required',
			'class_names_classID' => 'required',
			'sectionID' => 'required',
			'csvFile' => 'required',
		]);

		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {





			$failed_rows = $added_ids = array();
			$file = Input::file('csvFile');

			//$timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
			$url = $this->csv_location . $file->getClientOriginalName();

			$file_path = $file->move(public_path() . $this->csv_location, $url);

			if ($file_path) {

				$temp = explode("\\", $file_path);
				$csvFile = end($temp);
				$reader = Reader::createFromPath(public_path() . '/csv/' . $csvFile);
				$results = $reader->fetch();
				$ii = 0;
				$total = 0;


				foreach ($results as $row) {

					if ($ii > 0) {
						try {
							$user = new User();

							$user->branchID = $request->branches_branchID;

							$user->roles_roleID = 4;

							$user->reg_number = $row[0];


							$user->user_name = $row[1];


							$user->first_name = $row[2];


							$user->last_name = $row[3];


							$user->email_id = $row[4];

							if ($request->new_password) {
								$user->password = Hash::make($row[0]);
							}


							$user->mobile = $row[5];


							$user->dob = new DateTime(date("Y-m-d", strtotime(str_replace("-", "/", $row[6]))));


							$d1 = new DateTime(date("Y-m-d", strtotime(str_replace("-", "/", $row[6]))));
							$d2 = new DateTime(date('Y-m-d'));
							$diff = $d2->diff($d1);

							$user->age = $diff->y;


							$status = $user->save();

							if($status){
								$status=false;
								$userID = $user->userID;
								$ClassesHasUsers = new ClassesHasUsers();
								$ClassesHasUsers->userID = $userID;
								$ClassesHasUsers->classID = $request->class_names_classID;
								$ClassesHasUsers->sectionID = $request->sectionID;
								$status = $ClassesHasUsers->save();

								if ($status) {
									$total += 1;

								}
							}


						} catch (QueryException $e) {
							$failed_rows[] = $ii;
						}
					}

					$ii += 1;
				}

			}
			$const_role_name = $this->constant['super_admin'];

			$all_branches = array();

			if (Session::get('role_name') == $const_role_name) {
				$all_branches = Branch::all();
			}
			return view('user.upload_form', compact('all_branches', 'const_role_name','failed_rows', 'total'));
		}


	}



}
