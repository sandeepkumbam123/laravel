<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
	use Notifiable;
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */


	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $table = 'users';
	protected $primaryKey = 'userID';


	public $fillable = [
		'branchID',
		'classID',
		'sectionID',
		'roles_roleID',
		'user_name',
		'first_name',
		'last_name',
		'email_id',
		'password',
		'mobile',
		'dob',
		'age',
		'gender',
		'cretedby'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'userID' => 'integer',
		'branchID' => 'integer',
		'classID' => 'integer',
		'sectionID' => 'integer',
		'roles_roleID' => 'integer',
		'user_name' => 'string',
		'first_name' => 'string',
		'last_name' => 'string',
		'email_id' => 'string',
		'password' => 'string',
		'mobile' => 'string',
		'dob' => 'date',
		'age' => 'integer',
		'gender' => 'string',
		'cretedby' => 'integer'
	];

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public static $rules = [

	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function branch() {
		return $this->belongsTo(\App\Branch::class,"branchID");
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function role() {
		return $this->hasOne(\App\Role::class,"roleID");
	}


	

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function userHasRoles() {
		return $this->hasMany(\App\UserHasRole::class);
	}

	public function classHasUsers() {
		return $this->hasMany(\App\ClassesHasUsers::class,"userID");
	}

}