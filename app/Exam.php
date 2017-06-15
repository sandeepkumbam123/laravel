<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model {

	use SoftDeletes;

	public $table = 'exams';

	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	protected $dates = ['deleted_at'];

	protected $primaryKey = 'examID';

	public $fillable = [
		'class_names_classID',
		'branches_branchID',
		'subjectIDS',
		'chapterIDS',
		'exam_manualID',
		'critical_level',
		'total_marks',
		'pass_percentage',
		'is_active',
		'exam_date',
		'negative_mark',
		'duration',
		'note',
		'questions',
		'createdby'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'examID' => 'integer',
		'class_names_classID' => 'integer',
		'branches_branchID' => 'integer',
		'subjectIDS' => 'string',
		'chapterIDS' => 'string',
		'exam_manualID' => 'string',
		'critical_level' => 'integer',
		'total_marks' => 'float',
		'pass_percentage' => 'float',
		'is_active' => 'string',
		'negative_mark' => 'float',
		'duration' => 'float',
		'note' => 'string',
		'questions' => 'string',
		'createdby' => 'integer'
	];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function branch() {
		return $this->belongsTo(\App\Branch::class,"branches_branchID");
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function className() {
		return $this->belongsTo(\App\Class_name::class,"class_names_classID");
	}


	public function exam_subjects() {
		return $this->hasMany(\App\ExamHasSubjects::class,"exams_examID");
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 **/
	public function examResults() {
		//return $this->hasMany(\App\ExamResult::class);
	}

}