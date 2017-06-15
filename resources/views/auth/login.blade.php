@extends('layouts.app')

@section('content')
    <div class="container" style="width: 100%">
        <div class="row">
            <div class="login-info">
                <div class="panel panel-default" style="border-top: none">

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/secure/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">User Id</label>

                                <div class="col-md-6">
                                    <input id="user_name" type="user_name" class="form-control" name="user_name"
                                           value="{{ old('user_name') }}" autocomplete="off">

                                    @if ($errors->has('user_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Login
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if(Session::has('status'))
                            <div class="alert alert-warning col-md-offset-2 text-center">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

