@extends('layouts.portalLayout')
@section('content')
    <section class="content">
        <h1>
            Edit Student
        </h1>
        <form method='get' action='{!!url("portal/user")!!}'>
            <button class='btn btn-danger'>All Students</button>
        </form>
        <br>
        <form method='POST' action='{!! url("portal/user")!!}/{!!$user->
        userID!!}/update' enctype="multipart/form-data">
            <input type='hidden' name='_token' value='{{Session::token()}}'>


            <div class="form-group has-feedback {{ $errors->has('branches_branchID') ? ' has-error' : '' }}">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    @foreach($all_branches  as $branch)
                        <option value="{{ $branch->branchID }}"
                                @if (old('branches_branchID',$user->branchID) == $branch->branchID) selected="selected" @endif>{{ ucfirst($branch->branch_name) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('branches_branchID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('branches_branchID') }}</strong>
                    </span>

                @endif

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="{{$user->branchID }}">
                <?php } ?>

            </div>

            <div class="form-group has-feedback {{ $errors->has('class_names_classID') ? ' has-error' : '' }}">
                <label for="class_name">Class</label>

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


            <div class="form-group has-feedback {{ $errors->has('sectionID') ? ' has-error' : '' }}">
                <label for="class_name">Section</label>

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


            <div class="form-group has-feedback {{ $errors->has('reg_number') ? ' has-error' : '' }}">
                <label for="reg_number">Register Number</label>
                <input id="reg_number" name="reg_number" type="reg_number" class="form-control" value="{{old('reg_number',$user->reg_number)}}" autocomplete="off">
                <input type="hidden" name="old_reg_number" value="{{$user->reg_number}}">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('reg_number'))
                    <span class="help-block">
                        <strong>{{ $errors->first('reg_number') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('user_name') ? ' has-error' : '' }}">
                <label for="user_name">User Name</label>
                <input id="user_name" name="user_name" type="text" class="form-control" value="{{old('user_name',$user->user_name)}}" autocomplete="off">
                <input type="hidden" name="old_user_name" value="{{$user->user_name}}">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('user_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('user_name') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" class="form-control" value="{{old('first_name',$user->first_name)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" class="form-control" value="{{old('last_name',$user->last_name)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group has-feedback {{ $errors->has('email_id') ? ' has-error' : '' }}">
                <label for="email">E-mail</label>
                <input id="email" name="email_id" type="email" class="form-control" value="{{old('email_id',$user->email_id)}}" autocomplete="off">
                <input type="hidden" name="old_email_id" value="{{$user->email_id}}">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('email_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_id') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('new_password') ? ' has-error' : '' }}">
                <label for="password">NEW Password</label>
                <input id="password" name="new_password" type="text" class="form-control" value="{{old('new_password')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('new_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile" type="text" class="form-control" value="{{old('mobile',$user->mobile)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('dob') ? ' has-error' : '' }}">
                <label for="dob">DOB</label>
                <input id="dob" name="dob" type="date" class="form-control" value="{{old('dob',$user->dob)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('dob'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group {{ $errors->has('new_image') ? ' has-error' : '' }}">
                <label for="image">Profile Pic</label>
                <br>
                @if(!$errors->has('new_image'))

                    <div class="profile-pic">
                        <?php if($user->profile_pic != ''){?>

                        <img src="{{ asset('public'.$user->profile_pic) }}" height="200"
                             width="200">
                        <?php }else{?>
                        <img src="{!!  asset("public"."/images/no_image.jpg") !!}" height="100" width="100">
                        <?php
                        }
                            ?>
                        <div class="edit delete_image"><i class="fa fa-pencil fa-lg"></i></div>
                    </div>



                @endif
                <input type="file" name="new_image" class="form-control" id="new_image"
                       @if($errors->has('new_image'))style="display: block;" @else  style="display:none;" @endif>

                <input type="hidden" id="old_image" name="old_image" value="{{$user->profile_pic}}">
                <input type="hidden" id="is_new_image" name="is_new_image" value="no">
            </div>


            <button class='btn btn-primary' type='submit'>Update</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', $user->branchID); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID', $user->classID); ?>">
            <input type="hidden" id="old_section" value="<?php echo old('old_section', $user->sectionID); ?>">

        </form>
    </section>
@endsection

@section('page_scripts')

    <script>

        $(".delete_image").click(function (e) {
            e.preventDefault();
            //old_image,is_new_image,current_image
            $(".profile-pic").remove();
            $("#is_new_image").val("yes");
            $("#new_image").show();
            return false;

        });
    </script>







@endsection

<!-- fghfghffghfgfg contact form starts here  -->
<input type="text" name="username"
       id="user_name" class="a aasas asas"

       style="" data-abcd="asdasdsa">
