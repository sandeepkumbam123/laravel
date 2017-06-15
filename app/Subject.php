<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subject.
 *
 * @author  The scaffold-interface created at 2017-05-20 06:19:08pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Subject extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'subjects';

	protected $primaryKey = 'subjectID';
}
