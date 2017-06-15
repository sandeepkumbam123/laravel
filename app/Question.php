<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model {
	use SoftDeletes;

	public $table = 'questions';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	protected $dates = ['deleted_at'];

	protected $primaryKey = 'questionID';

	public $fillable = [
		'subjects_subjectID',
		'chapters_chapterID',
		'syllabuses_syllabuseID',
		'class_names_classID',
		'question',
		'mark',
		'crirical_level',
		'is_image',
		'createdby'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'questionID' => 'integer',
		'subjects_subjectID' => 'integer',
		'chapters_chapterID' => 'integer',
		'syllabuses_syllabuseID' => 'integer',
		'class_names_classID' => 'integer',
		'question' => 'string',
		'mark' => 'float',
		'crirical_level' => 'string',
		'is_image' => 'string',
		'createdby' => 'integer'
	];



	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function className() {
		return $this->belongsTo(\App\ClassName::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function syllabus() {
		return $this->belongsTo(\App\Syllabus::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function chapter() {
		return $this->belongsTo(\App\Chapter::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function subject() {
		return $this->belongsTo(\App\Subject::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function questionOptions() {
		return $this->hasOne(\App\QuestionOption::class,"questions_questionID");
	}
}
