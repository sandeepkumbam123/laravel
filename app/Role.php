<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $table = 'roles';
	protected $primaryKey = 'roleID';
	
}
