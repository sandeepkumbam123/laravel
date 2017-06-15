@extends('layouts.portalLayout')
@section('content')


    <section class="content">
        <h1>
            Create chapter
        </h1>
        <form method='get' action='{!!url("portal/chapter")!!}'>
            <button class='btn btn-danger'>Show All Chapter</button>
        </form>
        <br>
        <form method='POST' action='{!!url("portal/chapter")!!}'>
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

            <div class="form-group has-feedback {{ $errors->has('chapter') ? ' has-error' : '' }}">
                <label for="chapter">Chapter</label>
                <input id="chapter" name="chapter" type="text" class="form-control" value="{{old('chapter')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('chapter'))
                    <span class="help-block">
                        <strong>{{ $errors->first('chapter') }}</strong>
                    </span>
                @endif
            </div>


            <button class='btn btn-primary' type='submit'>Create</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_subject" value="<?php echo old('subjects_subjectID'); ?>">

        </form>
    </section>
@endsection