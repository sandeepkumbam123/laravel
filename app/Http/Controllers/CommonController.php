<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller {

	public function getClasses(Request $request) {
		$input = $request->except('_token');
		$branch_id = $input['branch_id'];
		if ($branch_id) {
			$class_data = DB::select("SELECT * FROM class_names WHERE branches_branchID=$branch_id and deleted_at IS NULL");
			return json_encode($this->get_data($class_data, "classID", "class_name", "ajax_req"));
		} else
			return false;
	}


	public function getSubjects(Request $request) {
		$input = $request->except('_token');
		$class_id = $input['class_id'];
		$branch_id = $input['branch_id'];
		if ($class_id && $branch_id) {
			$subject_data = DB::table('subjects')
				->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
				->where('class_names.branches_branchID', '=', $branch_id)
				->where('subjects.class_names_classID', '=', $class_id)
				->where('class_names.deleted_at', '=', NULL)
				->where('subjects.deleted_at', '=', NULL)
				->select('subjects.*')
				->get();
			$subject_data = json_decode($subject_data);

			return json_encode($this->get_data($subject_data, "subjectID", "subject", "ajax_req"));
		} else
			return false;
	}


	public function getChapters(Request $request) {

		$input = $request->except('_token');
		$class_id = $input['class_id'];
		$branch_id = $input['branch_id'];
		$subject_id = $input['subject_id'];
		$flag = $input['flag'];


		if ($class_id && $branch_id && $subject_id && $flag == "multiple") {
			$subject_ids = explode(",", $subject_id);

			$chapter_data = DB::table('chapters')
				->join('subjects', 'subjects.subjectID', '=', 'chapters.subjects_subjectID')
				->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
				->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
				->whereIn('subjects.subjectID', $subject_ids)
				->where('class_names.classID', '=', $class_id)
				->where('branches.branchID', '=', $branch_id)
				->whereNull('branches.deleted_at')
				->whereNull('class_names.deleted_at')
				->whereNull('subjects.deleted_at')
				->whereNull('chapters.deleted_at')
				->select('chapters.*')
				->get();
			$chapter_data = json_decode($chapter_data);

			return json_encode($this->get_data($chapter_data, "chapterID", "chapter", "ajax_req"));
		} else if ($class_id && $branch_id && $subject_id && $flag == "single") {
			$chapter_data = DB::table('chapters')
				->join('subjects', 'subjects.subjectID', '=', 'chapters.subjects_subjectID')
				->join('class_names', 'class_names.classID', '=', 'subjects.class_names_classID')
				->join('branches', 'branches.branchID', '=', 'class_names.branches_branchID')
				->where('subjects.subjectID', '=', $subject_id)
				->where('class_names.classID', '=', $class_id)
				->where('branches.branchID', '=', $branch_id)
				->whereNull('branches.deleted_at')
				->whereNull('class_names.deleted_at')
				->whereNull('subjects.deleted_at')
				->whereNull('chapters.deleted_at')
				->select('chapters.*')
				->get();
			$chapter_data = json_decode($chapter_data);
			return json_encode($this->get_data($chapter_data, "chapterID", "chapter", "ajax_req"));

		} else
			return json_encode(false);

	}


	public function getSections(Request $request){
		$input = $request->except('_token');
		$class_id = $input['class_id'];
		$branch_id = $input['branch_id'];

		if($class_id ){
			$section_data = DB::table('sections')
				->join('class_names', 'class_names.classID', '=', 'sections.class_names_classID')
				->where('sections.class_names_classID', '=', $class_id)
				->where('class_names.deleted_at', '=', NULL)
				->where('sections.deleted_at', '=', NULL)
				->select('sections.*')
				->get();
			$section_data = json_decode($section_data);

			return json_encode($this->get_data($section_data, "sectionID", "section_name", "ajax_req"));
		}else{
			return false;
		}
	}



	public function get_data($table_data, $id_field, $field_name, $flag) {
		$result = array();

		if ($flag == "ajax_req") {
			foreach ($table_data as $item) {

				$result[] = array($id_field => $item->$id_field, $field_name => $item->$field_name);
			}
		} else {
			foreach ($table_data as $item) {

				$result[$item->$id_field] = $item->$field_name;
			}
		}

		unset($item);
		return $result;
	}
}
