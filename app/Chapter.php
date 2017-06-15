<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Chapter.
 *
 * @author  The scaffold-interface created at 2017-05-25 03:20:10pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Chapter extends Model
{

  use SoftDeletes;

  protected $dates = ['deleted_at'];


  protected $table = 'chapters';
  protected $primaryKey = 'chapterID';


}
