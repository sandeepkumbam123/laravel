<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserAPIController extends Controller {
	/** @var  UserRepository */
	private $userRepository;

	public function __construct() {
		$this->constant = Config::get('constants.DEFAULT_DATA');
	}


	/**
	 * Display a listing of the User.
	 * GET|HEAD /users
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function login(Request $request) {
		$input = $request->all();
		$email = $input['email'];
		$password = $input['password'];

		if (Auth::attempt(['email_id' => $email, 'password' => $password])) {
			$result = User::with('role')->with("classHasUsers")->with("branch")->where('email_id', $email)->get();
			$result = $result[0];

			if ($result->deleted_at == NULL) {

				$const_teach_role = $this->constant['teacher'];
				$const_student_role = $this->constant['student'];

				$cur_role=$cur_roleID = '';
				if (empty($result->role)) {
					$role_data = DB::table('users')
						->join('roles', 'users.roles_roleID', '=', 'roles.roleID')
						->where("userID", $result->userID)
						->select('users.*', 'roles.*')
						->get();
					$role_data = $role_data[0];
					$cur_role = $role_data->role;
					$cur_roleID=$role_data->roleID;

				} else {
					$cur_role = $result->role->role;
					$cur_roleID=$result->role->roleID;
				}

				/** if the role is a teacher**/
				if ($cur_role == $const_teach_role) {
					$result_cpy = json_decode($result);
					$class_list = $subject_list = $section_list = array();
					foreach ($result_cpy->class_has_users as $data) {
						$class_list[] = $data->classID;
						$subject_list[] = $data->subjectID;
						$section_list[] = $data->sectionID;
					}
					unset($data);
					$class_data = DB::table('class_names')->whereIn('classID', $class_list)->get();
					$subject_data = DB::table('subjects')->whereIn('subjectID', $subject_list)->get();
					$section_data = DB::table('sections')->whereIn('sectionID', $section_list)->get();

					$keys = array('user_id', 'branch_id', 'branch_name', 'section', 'class', 'subject', 'is_success', 'session_id', 'user_name', 'role', 'role_id', 'ErrorCode', 'ErrorMessage');

					$values = array($result->userID, $result->branchID, $result->branch->branch_name, $section_data, $class_data, $subject_data, true, $this->randomID(), $result->first_name . ' ' . $result->last_name, $cur_role, $cur_roleID, NULL, NULL);
					return response(array(array_combine($keys, $values)), 200);

				} /** if the role is a student **/
				else if ($cur_role == $const_student_role) {
					$result_cpy = json_decode($result);
					$class_list = $subject_list = $section_list = array();
					foreach ($result_cpy->class_has_users as $data) {
						$class_list[] = $data->classID;
						$section_list[] = $data->sectionID;
					}
					$class_data = DB::table('class_names')->whereIn('classID', $class_list)->get();
					$section_data = DB::table('sections')->whereIn('sectionID', $section_list)->get();

					$keys = array('user_id', 'branch_id', 'branch_name', 'section', 'class', 'subject', 'is_success', 'session_id', 'user_name', 'role', 'role_id', 'ErrorCode', 'ErrorMessage');

					$values = array($result->userID, $result->branchID, $result->branch->branch_name, $section_data, $class_data, NULL, true, $this->randomID(), $result->first_name . ' ' . $result->last_name, $cur_role, $cur_roleID, NULL, NULL);
					return response(array(array_combine($keys, $values)), 200);


				} else {
					$keys = array('user_id', 'branch_id', 'branch_name', 'section', 'class', 'subject', 'is_success', 'session_id', 'user_name', 'role', 'role_id', 'ErrorCode', 'ErrorMessage');
					$values = array($result->userID, $result->branchID, $result->branch->branch_name, NULL, NULL, NULL, true, $this->randomID(), $result->first_name . ' ' . $result->last_name, $result->role->role, $result->role->roleID, NULL, NULL);
					return response(array(array_combine($keys, $values)), 200);
				}


			} else {
				$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
				$values = array(false, '404', "No such user found ");
				return response(array(array_combine($keys, $values)), 404);
			}
		} else {

			$keys = array('is_success', 'ErrorCode', 'ErrorMessage');
			$values = array(false, '404', "Invalid Credentials");
			return response(array(array_combine($keys, $values)), 404);
		}


	}

	public function randomID() {

		return strtoupper(bin2hex(openssl_random_pseudo_bytes(4)));
	}


	public function addUser(Request $request) {
		$input = $request->all();
		$email = $input['email'];
		$password = $input['password'];
	}


	public function searchStudent(Request $request) {
		//TO DO: Anyone can see student details?
		$input = $request->all();
		$reg_number = $input['reg_number'];
		$user = DB::table('users')
			->join('classes_has_users', 'classes_has_users.id', '=', 'users.userID')
			->join('class_names', 'class_names.classID', '=', 'classes_has_users.classID')
			->join('branches', 'branches.branchID', '=', 'users.branchID')
			->where('users.reg_number', '=', $reg_number)
			->whereNull('classes_has_users.deleted_at')
			->whereNull('class_names.deleted_at')
			->whereNull('users.deleted_at')
			->select('users.userID', 'users.branchID', 'users.reg_number', 'users.user_name', 'users.first_name', 'users.last_name', 'users.email_id', 'users.dob', 'users.mobile', 'users.age', 'users.gender', 'class_names.class_name', 'branches.branch_name')
			->get();
		return response(array($user), 200);

	}


}
