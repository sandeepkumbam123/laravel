@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Edit Class Name
        </h1>
        <form method='get' action='{!!url("portal/class")!!}'>
            <button class='btn btn-danger'>Show All Class</button>
        </form>
        <br>
        <form method='POST' action='{!! url("portal/class")!!}/{!!$class_name->
        classID!!}/update'>
            <input type='hidden' name='_token' value='{{Session::token()}}'>
            <div class="form-group has-feedback {{ $errors->has('branches_branchID') ? ' has-error' : '' }}">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    @foreach($all_branches  as $branch)
                        <option value="{{ $branch->branchID }}"
                                @if (old('branches_branchID',$class_name->branches_branchID) == $branch->branchID) selected="selected" @endif>{{ ucfirst($branch->branch_name) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('branches_branchID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('branches_branchID') }}</strong>
                    </span>

                @endif

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="{{$class_name->branches_branchID}}">
                <?php } ?>

            </div>


            <div class="form-group has-feedback {{ $errors->has('class_name') ? ' has-error' : '' }}">
                <label for="class_name">Class Name</label>
                <input id="class_name" name="class_name" type="class_name" class="form-control" value="{{old('class_name',$class_name->
            class_name)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('class_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('class_name') }}</strong>
                    </span>
                @endif
            </div>
            <button class='btn btn-primary' type='submit'>Update</button>
        </form>
    </section>
@endsection