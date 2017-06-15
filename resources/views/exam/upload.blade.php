@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Upload Question and Create Exam
        </h1>
        <form method='get' action='{!!url("portal/exam-list")!!}'>
            <button class='btn btn-danger'>Show All Exams</button>
        </form>
        <br>
        <form method='POST' action='{!!url("portal/exam/upload")!!}' enctype="multipart/form-data">
            <input type='hidden' name='_token' value='{{Session::token()}}'>

            <div class="form-group has-feedback {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" class="form-control" value="{{old('title')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
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


            <div class="form-group has-feedback {{ $errors->has('subjectIDS') ? ' has-error' : '' }}">
                <label for="subject">Subject</label>

                <select id="subject_name" name="subjectIDS[]" class="form-control" multiple data-domulti="yes">


                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('subjectIDS'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subjectIDS') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('chapterIDS') ? ' has-error' : '' }}">
                <label for="chapterIDS">Chapter</label>

                <select id="chapter_name" name="chapterIDS[]" class="form-control" multiple data-domulti="yes">


                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('chapterIDS'))
                    <span class="help-block">
                        <strong>{{ $errors->first('chapterIDS') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('exam_date') ? ' has-error' : '' }}">
                <label for="exam_date">Exam Date</label>
                <input id="exam_date" name="exam_date" type="date" class="form-control" value="{{old('exam_date')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('exam_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('exam_date') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('exam_manualID') ? ' has-error' : '' }}">
                <label for="exam_manualID">Exam ID</label>
                <input id="exam_manualID" name="exam_manualID" type="text" class="form-control" value="{{old('exam_manualID',$uniqid)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('exam_manualID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('exam_manualID') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('critical_level') ? ' has-error' : '' }}">

                <select id="critical_level" name="critical_level" class="form-control">
                    <option value="">Select A Critical Level</option>
                    @foreach($critical_level  as $key=>$value)
                        <option value="{{ $key }}"
                                @if (old('critical_level') == $key) selected="selected" @endif>{{ ucfirst($value) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('critical_level'))
                    <span class="help-block">
                        <strong>{{ $errors->first('critical_level') }}</strong>
                    </span>

                @endif

            </div>


            <div class="form-group has-feedback {{ $errors->has('total_marks') ? ' has-error' : '' }}">
                <label for="total_marks">Total Marks</label>
                <input id="total_marks" name="total_marks" type="number" class="form-control" value="{{old('total_marks')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('total_marks'))
                    <span class="help-block">
                        <strong>{{ $errors->first('total_marks') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('pass_percentage') ? ' has-error' : '' }}">
                <label for="pass_percentage">Pass Percentage</label>
                <input id="pass_percentage" name="pass_percentage" type="number" class="form-control" value="{{old('pass_percentage')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('pass_percentage'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pass_percentage') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('negative_mark') ? ' has-error' : '' }}">
                <label for="negative_mark">Negative Mark</label>
                <input id="negative_mark" name="negative_mark" type="number" class="form-control" value="{{old('negative_mark')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('negative_mark'))
                    <span class="help-block">
                        <strong>{{ $errors->first('negative_mark') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('duration') ? ' has-error' : '' }}">
                <label for="duration">Duration(In Minutes)</label>
                <input id="duration" name="duration" type="number" class="form-control" value="{{old('duration')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('duration'))
                    <span class="help-block">
                        <strong>{{ $errors->first('duration') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('note') ? ' has-error' : '' }}">
                <label for="note">Notes</label>

                <textarea id="note" name="note" rows="6" class="form-control">{{old('note')}}</textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('note'))
                    <span class="help-block">
                        <strong>{{ $errors->first('note') }}</strong>
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




            <hr>

            <button class='btn btn-primary' type='submit'>Create Exam</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_subject" value='<?php echo json_encode(old('subjectIDS')); ?>'>
            <input type="hidden" id="old_chapter" value='<?php echo json_encode(old('chapterIDS')); ?>'>

        </form>
    </section>
@endsection