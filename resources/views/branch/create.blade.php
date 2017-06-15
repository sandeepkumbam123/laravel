@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Create branch
        </h1>
        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif

        <form method='get' action='{!!url("portal/branch")!!}'>
            <button class='btn btn-danger'>Show Branches</button>
        </form>
        <br>
        <form method='POST' action='{!!url("portal/branch")!!}'>
            <input type='hidden' name='_token' value='{{Session::token()}}'>
            <div class="form-group has-feedback {{ $errors->has('syllabuses_syllabuseID') ? ' has-error' : '' }}">

                <select id="syllabuses_syllabuseID" name="syllabuses_syllabuseID" class="form-control">
                    <option value="">Select A Syllabus</option>
                    @foreach($syllabus_list  as $syllabus)
                        <option value="{{ $syllabus->syllabuseID }}"
                                @if (old('syllabuses_syllabuseID') == $syllabus->syllabuseID) selected="selected" @endif>{{ ucfirst($syllabus->syllabus) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('syllabuses_syllabuseID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('syllabuses_syllabuseID') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group has-feedback {{ $errors->has('branch_name') ? ' has-error' : '' }}">
                <label for="branch_name">Branch Name</label>
                <input id="branch_name" name="branch_name" type="text" class="form-control" value="{{old('branch_name')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('branch_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('branch_name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{old('email')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('contact') ? ' has-error' : '' }}">
                <label for="contact">Contact</label>
                <input id="contact" name="contact" type="text" class="form-control" value="{{old('contact')}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('contact'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contact') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="question">Address</label>
                <textarea rows="7" name="address" id="address" class="form-control">{{old('address')}}</textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </div>
            <button class='btn btn-primary' type='submit'>Create</button>
        </form>
    </section>
@endsection