@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Create Question
        </h1>
        <form method='get' action='{!!url("portal/question")!!}'>
            <button class='btn btn-danger'>Show All Questions</button>
        </form>
        <br>
        <form method='POST' action='{!!url("portal/question")!!}' id="create_question" enctype="multipart/form-data">
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


            <div class="form-group has-feedback {{ $errors->has('question') ? ' has-error' : '' }}">
                <label for="question">Question</label>

                <textarea id="question" name="question" rows="6" class="form-control">{{old('question')}}</textarea>

                <br/>
                <input type="file" name="image_question" id="image_question">
                <br/>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('question'))
                    <span class="help-block">
                        <strong>{{ $errors->first('question') }}</strong>

                    </span>
                @endif

                <span class="help-block hidden" id="image_question_error" style="color: #a94442">
                        <strong>Question is required field</strong>

                    </span>


            </div>


            <div class="form-group has-feedback {{ $errors->has('mark') ? ' has-error' : '' }}">
                <label for="mark">Mark</label>
                <input id="mark"  name="mark" type="number" class="form-control" value="{{old('mark')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('mark'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mark') }}</strong>
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
            {{--<div class="form-group">
                <label>
                    <input id="is_image" name="is_image" type="checkbox">
                    Is a Image Question
                </label>
            </div>--}}
            <hr>
            <h4>Question's Options</h4>
            <hr>
            <div class="form-group has-feedback {{ $errors->has('option1') ? ' has-error' : '' }}">
                <label for="option1">Option-1</label>
                <textarea id="option1" class="form-control" name="option1">{{old('option1')}}</textarea>
                <br/>
                <input type="file" name="option1_image" id="option1_image">
                <br/>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('option1'))
                    <span class="help-block">
                        <strong>{{ $errors->first('option1') }}</strong>
                    </span>
                @endif

                <span class="help-block hidden" id="option1_image_error">
                        <strong>Option-1 is required field</strong>

                </span>
            </div>


            <div class="form-group has-feedback {{ $errors->has('option2') ? ' has-error' : '' }}">
                <label for="option2">Option-2</label>
                <textarea id="option2" class="form-control" name="option2">{{old('option2')}}</textarea>

                <br/>
                <input type="file" name="option2_image" id="option2_image">
                <br/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('option2'))
                    <span class="help-block">
                        <strong>{{ $errors->first('option2') }}</strong>
                    </span>
                @endif

                <span class="help-block hidden" id="option2_image_error">
                        <strong>Option-2 is required field</strong>

                </span>

            </div>


            <div class="form-group has-feedback {{ $errors->has('option3') ? ' has-error' : '' }}">
                <label for="option3">Option-3</label>
                <textarea id="option3" class="form-control" name="option3">{{old('option3')}}</textarea>
                <br/>
                <input type="file" name="option3_image" id="option4_image">
                <br/>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('option3'))
                    <span class="help-block">
                        <strong>{{ $errors->first('option3') }}</strong>
                    </span>
                @endif

                <span class="help-block hidden" id="option3_image_error">
                        <strong>Option-3 is required field</strong>

                </span>
            </div>


            <div class="form-group has-feedback {{ $errors->has('option4') ? ' has-error' : '' }}">
                <label for="option4">Option-4</label>
                <textarea id="option4" class="form-control" name="option4">{{old('option4')}}</textarea>

                <br/>
                <input type="file" name="option4_image" id="option4_image">
                <br/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('option4'))
                    <span class="help-block">
                        <strong>{{ $errors->first('option4') }}</strong>
                    </span>
                @endif
                <span class="help-block hidden" id="option4_image_error">
                        <strong>Option-1 is required field</strong>

                </span>
            </div>

            <div class="form-group has-feedback {{ $errors->has('answer') ? ' has-error' : '' }}">

                <select id="answer" name="answer" class="form-control">
                    <option value="">Select An Answer</option>
                    @foreach($answer_list  as $key=>$value)
                        <option value="{{ $key }}"
                                @if (old('answer') == $key) selected="selected" @endif>{{ ucfirst($value) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('answer'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer') }}</strong>
                    </span>

                @endif

            </div>

            <div class="form-group has-feedback {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes">Notes</label>
                <textarea id="notes" class="form-control" name="notes">{{old('notes')}}</textarea>


                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('notes'))
                    <span class="help-block">
                        <strong>{{ $errors->first('notes') }}</strong>
                    </span>
                @endif
            </div>


            <button class='btn btn-primary' type='submit'>Create</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_subject" value="<?php echo old('subjects_subjectID'); ?>">
            <input type="hidden" id="old_chapter" value="<?php echo old('chapters_chapterID'); ?>">

        </form>
    </section>
@endsection

@section('page_scripts')
    <script>
        /*$('#create_question').submit(function (e) {

            if ($('#image_question').val() == '' && $('#question').val() == '') {

                $("#image_question_error").removeClass("hidden");
                $("#image_question_error").parent().addClass("has-error");

            }
            if ($('#option1_image').val() == '' && $('#option1').val() == '') {

                $("#option1_image_error").removeClass("hidden");
                $("#option1_image_error").parent().addClass("has-error");

            }
            if ($('#option2_image').val() == '' && $('#option2').val() == '') {

                $("#option2_image_error").removeClass("hidden");
                $("#option2_image_error").parent().addClass("has-error");

            }
            if ($('#option3_image').val() == '' && $('#option3').val() == '') {

                $("#option3_image_error").removeClass("hidden");
                $("#option3_image_error").parent().addClass("has-error");

            }
            if ($('#option4_image').val() == '' && $('#option4').val() == '') {

                $("#option4_image_error").removeClass("hidden");
                $("#option4_image_error").parent().addClass("has-error");

            }


            if (($('#image_question').val() == '' && $('#question').val() == '') || ($('#option1_image').val() == '' && $('#option1').val() == '') ||
                    ($('#option2_image').val() == '' && $('#option2').val() == '') || ($('#option3_image').val() == '' && $('#option3').val() == '')
                    || ($('#option4_image').val() == '' && $('#option4').val() == '')) {
                e.preventDefault();
                return false;

            }


        });*/
    </script>
@endsection