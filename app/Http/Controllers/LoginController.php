<?php

namespace App\Http\Controllers;

use App\Permission;
use App\RoleHasPermission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class LoginController extends Controller {


	protected $all_roles = array();
	protected $query_operator = '';
	protected $field_value = '';
	protected $constant = array();

	public function __construct() {
		$this->middleware('portalUser', ['except' => ['index', 'do_admin_login', 'logout'

		]]);
		$temp = Role::all();
		foreach ($temp as $role) {
			$this->all_roles[$role->roleID] = $role->role;
		}
		unset($role);
		Session::put('allRoles', $this->all_roles);
		
		$this->constant = Config::get('constants.DEFAULT_DATA');
	}

	public function index() {
		return view("auth.login");
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function do_admin_login(Request $request) {
		$user_name = $password = '';

		$v = Validator::make($request->all(), [
			'user_name' => 'required',
			'password' => 'required',
		]);


		if ($v->fails()) {
			return redirect()->back()->withInput()->withErrors($v->errors());
		} else {
			$valid_user = $user = false;
			$user_name = $request->input('user_name');
			$password = $request->input('password');
			$user = User::where('email_id', '=', $user_name)->first();

			if ($user) {
				$valid_user = Hash::check($password, $user->password);
			}

			if ($valid_user) {
				$user_roles_list = array();
				$role_data = RoleHasPermission::where('roles_roleID', '=', $user->roles_roleID);
				foreach ($role_data as $role) {
					$user_roles_list[] = $role->roles_roleID;
				}
				unset($role);

				Session::put('user_roles', $user_roles_list);
				Session::put('user_name', ucfirst($user->first_name));
				Session::put('role_id', $user->roles_roleID);
				Session::put('role_name', $this->all_roles[$user->roles_roleID]);
				Session::put('user_id', $user->userID);
				Session::put('branch_id', $user->branchID);

				return redirect('secure/dashboard');


			} else {
				Session::flash('status', 'Invalid credentials');
				return redirect()->back()->withInput();
			}
		}
	}


	public function viewDashboard() {

		$const_role_name = $this->constant['super_admin'];
		if (Session::get('role_name') == $const_role_name) {
			$this->query_operator = '!=';
			$this->field_value = '';
		} else {
			$this->query_operator = '=';
			$this->field_value = Session::get('branch_id');
		}

		$orgs=DB::table("org")->where('id','=',1)->get();
		$teachers= DB::table('users')->where('branchID', $this->query_operator, $this->field_value)->where('roles_roleID','=',3)->whereNull('deleted_at')->count();
		$users = DB::table('users')->where('branchID', $this->query_operator, $this->field_value)->where('roles_roleID','=',4)->whereNull('deleted_at')->count();
		$branches = DB::table('branches')->where('branchID', $this->query_operator, $this->field_value)->whereNull('deleted_at')->count();
		$classes = DB::table('class_names')->where('branches_branchID', $this->query_operator, $this->field_value)->whereNull('deleted_at')->count();
		$sections = DB::table('sections')
			->join('class_names', 'class_names.classID', '=', 'sections.class_names_classID')
			->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
			->where('class_names.branches_branchID', $this->query_operator, $this->field_value)
			->whereNull('branches.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('sections.deleted_at')
			->count();
		return view('home', compact('teachers','users', 'branches', 'classes', 'sections','orgs'));
	}


	public function logout() {
		Session::forget('user_roles');
		Session::forget('user_name');
		Session::forget('user_id');
		return redirect('secure/login');
	}


}
