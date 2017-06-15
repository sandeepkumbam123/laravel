@extends('layouts.portalLayout')
@section('content')
    <section class="content">
        <h1>
            Add Role To Teacher
        </h1>

        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif


        <form class='col s3' method='get' action='{!!url("portal/teacher")!!}'>
            <button class='btn btn-primary' type='submit'>Show All Teachers</button>
            <a href="{!! url("portal/teacher/$id/roles") !!}" class='btn btn-primary pull-right' type='submit'>Go Back</a>
        </form>

        <br>

        <form method='POST' action='{!!url("portal/teacher/saveRole")!!}' id="" enctype="multipart/form-data">
            <input type='hidden' name='_token' value='{{Session::token()}}'>

            @if ($errors->has('is_valid'))
                <span class="help-block has-error" style="color:red ">
                        <strong>{{ $errors->first('is_valid') }}</strong>
                    </span>
                <br>
            @endif

            <div class="form-group has-feedback {{ $errors->has('classID') ? ' has-error' : '' }}">

                <select id="classID" name="classID" class="form-control">
                    <option value="">Select A Class</option>
                    @foreach($class_list  as $this_class)
                        <option value="{{ $this_class->classID }}"
                                @if (old('classID') == $this_class->classID) selected="selected" @endif>{{ ucfirst($this_class->class_name) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('classID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('classID') }}</strong>
                    </span>

                @endif

                <div class="form-group has-feedback {{ $errors->has('sectionID') ? ' has-error' : '' }}">
                    <label for="section">Section</label>

                    <select id="sectionID" name="sectionID" class="form-control">
                        <option value="">Select A Section</option>

                    </select>

                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    @if ($errors->has('sectionID'))
                        <span class="help-block">
                        <strong>{{ $errors->first('sectionID') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group has-feedback {{ $errors->has('subjectID') ? ' has-error' : '' }}">
                    <label for="subjectID">Subjects</label>

                    <select id="subject_name" name="subjectID" class="form-control">
                        <option value="">Select A Subject</option>

                    </select>

                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    @if ($errors->has('subjectID'))
                        <span class="help-block">
                        <strong>{{ $errors->first('subjectID') }}</strong>
                    </span>
                    @endif
                </div>


                <button class='btn btn-primary' type='submit'>Create</button>


                <input type="hidden" value="{!! $branch_id !!}" id="old_branch">
                <input type="hidden" value="{!! old('sectionID') !!}" id="old_section">
                <input type="hidden" value="{!! old('subjectID') !!}" id="old_subject">
                <input type="hidden" name="userID" value="{!! $id !!}">


            </div>
        </form>
    </section>
@endsection
@section('page_scripts')
    <script>

        $(function () {
            var classID = $("#classID").val();
            var branch_id = $("#old_branch").val();

            if(classID){
                update_section_dropdown(branch_id, classID);
                update_subject_dropdown(branch_id, classID);
            }
            $("#classID").on("change", function () {
                var classID = $("#classID").val();
                if (classID) {
                    update_section_dropdown(branch_id, classID);
                    update_subject_dropdown(branch_id, classID);
                }else{
                    $("sectionID").empty();
                    $("subject_name").empty();
                }
            });


        });


    </script>
@endsection