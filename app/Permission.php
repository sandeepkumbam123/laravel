<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $dates = ['deleted_at'];
	public $timestamps = true;
	protected $table = 'permissions';
	protected $primaryKey = 'id';
}
