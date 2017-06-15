@extends('layouts.portalLayout')
@section('content')

<section class="content">
    <h1>
        Create section
    </h1>

    @if(Session::has('status'))
        <div class="alert alert-warning col-md-offset-2 text-center status_message">
            {{ Session::get('status') }}

        </div>
        <br>
    @endif

    <form method = 'get' action = '{!!url("portal/section")!!}'>
        <button class = 'btn btn-danger'>Show All Section</button>
    </form>
    <br>
    <form method = 'POST' action = '{!!url("portal/section")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
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


        <div class="form-group has-feedback {{ $errors->has('section_name') ? ' has-error' : '' }}">
            <label for="section_name">Section</label>
            <input id="section_name" name="section_name" type="section_name" class="form-control" value="{{old('section_name')}}" autocomplete="off">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            @if ($errors->has('section_name'))
                <span class="help-block">
                        <strong>{{ $errors->first('section_name') }}</strong>
                    </span>
            @endif
        </div>



        <button class = 'btn btn-primary' type ='submit'>Create</button>

        <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
        <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
    </form>
</section>
@endsection