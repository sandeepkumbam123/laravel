<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionOption extends Model {
	use SoftDeletes;

	public $table = 'question_options';
	public $timestamps = false;



	protected $dates = ['deleted_at'];

	protected $primaryKey = 'question_optionsID';

	public $fillable = [
		'questions_questionID',
		'option1',
		'is_option1_image',
		'option2',
		'is_option2_image',
		'option3',
		'is_option3_image',
		'option4',
		'is_option4_image',
		'answer',
		'notes'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'question_optionsID' => 'integer',
		'questions_questionID' => 'integer',
		'option1' => 'string',
		'is_option1_image' => 'string',
		'option2' => 'string',
		'is_option2_image' => 'string',
		'option3' => 'string',
		'is_option3_image' => 'string',
		'option4' => 'string',
		'is_option4_image' => 'string',
		'answer' => 'string',
		'notes' => 'string'
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	/*public function question() {
		return $this->belongsTo(\App\Question::class);
	}*/
}
