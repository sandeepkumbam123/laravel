<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Syllabus;
use Amranidev\Ajaxis\Ajaxis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use URL;

/**
 * Class SyllabusController.
 *
 * @author  The scaffold-interface created at 2017-06-14 04:28:42pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class SyllabusController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function index() {

		$syllabuses = Syllabus::paginate(60);
		return view('syllabus.index', compact('syllabuses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return  \Illuminate\Http\Response
	 */
	public function create() {

		return view('syllabus.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @return  \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validation_rule = Validator::make($request->all(), [
			'syllabus' => 'required|unique:syllabuses,syllabus',
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {

			$syllabus = new Syllabus();


			$syllabus->syllabus = $request->syllabus;


			$syllabus->createdby = Session::get('user_id');


			$status = $syllabus->save();


		}
		if ($status) {

			Session::flash('status', 'The New Syllabus created Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}
		return redirect('portal/syllabus');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function show($id, Request $request) {


		if ($request->ajax()) {
			return URL::to('portal/syllabus/' . $id);
		}

		$syllabus = Syllabus::findOrfail($id);
		return view('syllabus.show', compact('syllabus'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function edit($id, Request $request) {

		if ($request->ajax()) {
			return URL::to('portal/syllabus/' . $id . '/edit');
		}


		$syllabus = Syllabus::findOrfail($id);
		return view('syllabus.edit', compact('syllabus'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param    \Illuminate\Http\Request $request
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function update($id, Request $request) {
		$validation_rule = Validator::make($request->all(), [
			'syllabus' => 'required|unique:syllabuses,syllabus',
		]);


		if ($validation_rule->fails()) {
			return redirect()->back()->withInput()->withErrors($validation_rule->errors());
		} else {

			$syllabus = Syllabus::findOrfail($id);

		$syllabus->syllabus = $request->syllabus;

		$syllabus->createdby = $request->createdby;


			$status=$syllabus->save();
		}
		if ($status) {

			Session::flash('status', 'The Syllabus updated Successfully');
		} else {
			Session::flash('status', 'OOPS! Something went wrong. Please try again');
		}
		return redirect('portal/syllabus');
	}

	/**
	 * Delete confirmation message by Ajaxis.
	 *
	 * @link      https://github.com/amranidev/ajaxis
	 * @param    \Illuminate\Http\Request $request
	 * @return  String
	 */
	public function DeleteMsg($id, Request $request) {
		$msg = Ajaxis::BtDeleting('Warning!!', 'Would you like to remove This?', '/portal/syllabus/' . $id . '/delete');

		if ($request->ajax()) {
			return $msg;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param    int $id
	 * @return  \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$syllabus = Syllabus::findOrfail($id);
		$syllabus->delete();
		return URL::to('portal/syllabus');
	}
}
