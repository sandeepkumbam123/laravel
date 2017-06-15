@extends('layouts.portalLayout')

@section('content')

    <section class="content">
    <h1>
        Create syllabus
    </h1>
    <form method = 'get' action = '{!!url("portal/syllabus")!!}'>
        <button class = 'btn btn-danger'>All Syllabus</button>
    </form>
    <br>
    <form method = 'POST' action = '{!!url("portal/syllabus")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group has-feedback {{ $errors->has('syllabus') ? ' has-error' : '' }}">
            <label for="syllabus">Syllabus</label>
            <input id="syllabus" name="syllabus" type="syllabus" class="form-control" value="{{old('syllabus')}}" autocomplete="off">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            @if ($errors->has('syllabus'))
                <span class="help-block">
                        <strong>{{ $errors->first('syllabus') }}</strong>
                    </span>
            @endif
        </div>

        <button class = 'btn btn-primary' type ='submit'>Create</button>
    </form>
</section>
@endsection