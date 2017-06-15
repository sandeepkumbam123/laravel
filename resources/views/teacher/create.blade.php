@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Create Teacher
        </h1>


        <form method='get' action='{!!url("portal/teacher")!!}'>
            <button class='btn btn-danger'>All Teachers</button>
        </form>
        <br>
        <form method='POST' action='{!!url("portal/teacher")!!}' enctype="multipart/form-data">
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


            <div class="form-group has-feedback {{ $errors->has('user_name') ? ' has-error' : '' }}">
                <label for="user_name">User Name</label>
                <input id="user_name" name="user_name" type="text" class="form-control" value="{{old('user_name')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('user_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('user_name') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" class="form-control" value="{{old('first_name')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" class="form-control" value="{{old('last_name')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('email_id') ? ' has-error' : '' }}">
                <label for="email">E-mail</label>
                <input id="email" name="email_id" type="email" class="form-control" value="{{old('email_id')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('email_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_id') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Password</label>
                <input id="password" name="password" type="text" class="form-control" value="{{old('password')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile" type="text" class="form-control" value="{{old('mobile')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('dob') ? ' has-error' : '' }}">
                <label for="dob">DOB</label>
                <input id="dob" name="dob" type="date" class="form-control" value="{{old('dob')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('dob'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('profile_pic') ? ' has-error' : '' }}">
                <label for="profile_pic">Profile Picture</label>
                <input id="profile_pic" name="profile_pic" type="file" class="form-control" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('profile_pic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile_pic') }}</strong>
                    </span>
                @endif
            </div>

            <button class='btn btn-primary' type='submit'>Create</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_section" value="<?php echo old('sectionID'); ?>">


        </form>
    </section>
@endsection