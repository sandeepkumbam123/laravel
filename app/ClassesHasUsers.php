<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassesHasUsers extends Model
{
	use SoftDeletes;
	public $timestamps = true;
	protected $dates = ['deleted_at'];

	protected $table = 'classes_has_users';
	protected $primaryKey = 'id';

}
