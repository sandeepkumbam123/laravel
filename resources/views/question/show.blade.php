@extends('layouts.portalLayout')
@section('content')

	<section class="content">
		<h1>
			Show Question
		</h1>
		<br>
		<form method='get' action='{!!url("portal/question")!!}'>
			<button class='btn btn-primary'>Show All Questions</button>
		</form>
		<br>
		<table class='table table-bordered'>
			<thead>
			<th>Key</th>
			<th>Value</th>
			</thead>
			<tbody>
			<tr>
				<td>
					<b><i>subjects_subjectID : </i></b>
				</td>
				<td>{!!$question->subjects_subjectID!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>chapters_chapterID : </i></b>
				</td>
				<td>{!!$question->chapters_chapterID!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>syllabuses_syllabuseID : </i></b>
				</td>
				<td>{!!$question->syllabuses_syllabuseID!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>class_names_classID : </i></b>
				</td>
				<td>{!!$question->class_names_classID!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>question : </i></b>
				</td>
				<td>{!!$question->question!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>mark : </i></b>
				</td>
				<td>{!!$question->mark!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>crirical_level : </i></b>
				</td>
				<td>{!!$question->critical_level!!}</td>
			</tr>
			<tr>
				<td>
					<b><i>is_image : </i></b>
				</td>
				<td>{!!$question->is_image!!}</td>
			</tr>
			</tbody>
		</table>
	</section>
@endsection