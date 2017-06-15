@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            All Class
        </h1>

        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif

        <form class='col s3' method='get' action='{!!url("portal/class")!!}/create'>
            <button class='btn btn-primary' type='submit'>Create New Class</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff'>
            <thead>
            <th>ID</th>
            @if(Session::get('role_name') == $const_role_name)
                <th>Branch</th>
            @endif
            <th>Class</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($class_names as $class_name)
                <tr>
                    <td>{{$class_name->classID}}</td>
                    @if(Session::get('role_name') == $const_role_name)
                        <td>{!!$class_name->branch_name!!}</td>
                    @endif
                    <td>{!!$class_name->class_name!!}</td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/class/{!!$class_name->classID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/class/{!!$class_name->classID!!}/edit'><i class='material-icons'>Edit</i></a>
                        {{-- <a href='#' class='viewShow btn btn-warning btn-xs' data-link='/portal/class/{!!$class_name->classID!!}'><i class='material-icons'>Info</i></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </section>
@endsection