<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Class_name.
 *
 * @author  The scaffold-interface created at 2017-05-20 11:41:43am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Class_name extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'class_names';

	protected $primaryKey = 'classID';


	public function branch()
	{
		return $this->belongsTo(\App\Branch::class,"branches_branchID");
	}
	
	
	
}
