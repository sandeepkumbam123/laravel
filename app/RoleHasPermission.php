<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $table = 'role_has_permissions';
	protected $primaryKey = 'id';
}
