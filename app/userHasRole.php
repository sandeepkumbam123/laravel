<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userHasRole extends Model
{
	protected $dates = ['deleted_at'];
	public $timestamps = false;
	protected $table = 'user_has_roles';
	protected $primaryKey = 'roleID';
}
