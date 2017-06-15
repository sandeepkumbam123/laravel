<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section.
 *
 * @author  The scaffold-interface created at 2017-05-23 03:09:06am
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Section extends Model
{
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];
    
	
    protected $table = 'sections';

	protected $primaryKey = 'sectionID';
}
