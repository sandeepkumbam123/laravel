<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Branch.
 *
 * @author  The scaffold-interface created at 2017-05-20 06:17:58am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Branch extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'branches';
	protected $primaryKey = 'branchID';


	
	
}
