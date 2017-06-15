<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamResult extends Model {
	use SoftDeletes;

	public $table = 'exam_results';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	protected $dates = ['deleted_at'];
	protected $primaryKey = 'resultID';

	public $fillable = [
		'exams_examID',
		'total',
		'studentID',
		'user_answer_data',
		'is_pass'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'resultID' => 'integer',
		'exams_examID' => 'integer',
		'total' => 'float',
		'studentID' => 'integer',
		'user_answer_data' => 'string',
		'is_pass' => 'string'
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function exam() {
		return $this->belongsTo(\App\Exam::class, "exams_examID");
	}
}
