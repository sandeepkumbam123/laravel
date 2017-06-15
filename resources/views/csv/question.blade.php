@extends('layouts.portalLayout')
@section('content')

	<section class="content">
		<h1>
			Upload Questions
		</h1>
		<form method='get' action='{!!url("portal/question")!!}'>
			<button class='btn btn-danger'>Show All Questions</button>
		</form>
		<br>

		<?php if(isset($total) && $total>0){?>

		<div class="alert alert-success" role="alert" id="succ_div">
			Totally <strong><?php echo $total; ?> Questions</strong> has been upload to the DB successfully.
		</div>
		<br>
		<?php } ?>


		<?php if(isset($failed_rows) && count($failed_rows)>0){?>

		<div class="alert alert-danger" role="alert" id="fail_div" style="max-width:800px">
			<strong>Oh snap!</strong>The following row(s) has false data so didn't upload to the DB.
			<br><strong><?php echo implode(",",$failed_rows);?></strong>
		</div>
		<br>
		<?php } ?>


		<form method='POST' action='{!!url("portal/upload-questions")!!}' enctype="multipart/form-data">
			<input type='hidden' name='_token' value='{{Session::token()}}'>

			<div class="form-group has-feedback {{ $errors->has('branches_branchID') ? ' has-error' : '' }}">
				<?php if((Session::get('role_name') == $const_role_name)){ ?>
				<select id="branches_branchID" name="branches_branchID" class="form-control">
					<option value="">Select A Branch</option>
					@foreach($all_branches  as $branch)
						<option value="{{ $branch->branchID }}"
						        @if (old('branches_branchID') == $branch->branchID) selected="selected" @endif>{{ ucfirst($branch->branch_name) }}</option>

					@endforeach
				</select>

				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				@if ($errors->has('branches_branchID'))
					<span class="help-block">
                        <strong>{{ $errors->first('branches_branchID') }}</strong>
                    </span>

				@endif

				<?php }else{ ?>
				<input type="hidden" name="branches_branchID" value="{{Session::get('branch_id')}}">
				<?php } ?>

			</div>

			<div class="form-group has-feedback {{ $errors->has('class_names_classID') ? ' has-error' : '' }}">
				<label for="subject">Class</label>

				<select id="class_name" name="class_names_classID" class="form-control">
					<option value="">Select A Class</option>

				</select>

				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				@if ($errors->has('class_names_classID'))
					<span class="help-block">
                        <strong>{{ $errors->first('class_names_classID') }}</strong>
                    </span>
				@endif
			</div>


			<div class="form-group has-feedback {{ $errors->has('subjects_subjectID') ? ' has-error' : '' }}">
				<label for="subject">Subject</label>

				<select id="subject_name" name="subjects_subjectID" class="form-control">
					<option value="">Select A Subject</option>

				</select>

				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				@if ($errors->has('subjects_subjectID'))
					<span class="help-block">
                        <strong>{{ $errors->first('subjects_subjectID') }}</strong>
                    </span>
				@endif
			</div>

			<div class="form-group has-feedback {{ $errors->has('chapters_chapterID') ? ' has-error' : '' }}">
				<label for="chapters_chapterID">Chapter</label>

				<select id="chapter_name" name="chapters_chapterID" class="form-control">
					<option value="">Select A Chapter</option>

				</select>

				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				@if ($errors->has('chapters_chapterID'))
					<span class="help-block">
                        <strong>{{ $errors->first('chapters_chapterID') }}</strong>
                    </span>
				@endif
			</div>
			<div class="form-group has-feedback {{ $errors->has('csvFile') ? ' has-error' : '' }}">
				<label for="csvFile">csvFile</label>
				<input id="csvFile" name="csvFile" type="file" class="form-control">
				<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
				@if ($errors->has('csvFile'))
					<span class="help-block">
                        <strong>{{ $errors->first('csvFile') }}</strong>
                    </span>
				@endif
			</div>

			<button class='btn btn-primary' type='submit'>Upload</button>

			<input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
			<input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
			<input type="hidden" id="old_subject" value="<?php echo old('subjects_subjectID'); ?>">
			<input type="hidden" id="old_chapter" value="<?php echo old('chapters_chapterID'); ?>">

		</form>
	</section>

@endsection