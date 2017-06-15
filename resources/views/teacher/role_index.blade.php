@extends('layouts.portalLayout')

@section('content')
    <section class="content" style="overflow: auto;">
        <h1>
            {!! strtoupper($roles[0]->user_name) !!}'s Roles
        </h1>
        <br>
        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif
        <form class='col s3' method='get' action='{!!url("portal/teacher")!!}'>
            <button class='btn btn-primary' type='submit'>Show All Teachers</button>
            <a href='{!! url("portal/teacher/$id") !!}/create' class="btn btn-primary pull-right">Add Role</a>
        </form>


        <br>
        <br>
        <table class="table  table-bordered " style='background:#fff;' id="data_table">
            <thead>

            <th>Class</th>
            <th>Section</th>
            <th>Subject</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr>

                    <td>{!! ucfirst($role->class_name)!!}</td>
                    <td>{!! ucfirst($role->section_name)!!}</td>
                    <td>{!! ucfirst($role->subject) !!}</td>

                    <td style="width: 200px">
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/role/{!! $role->id !!}/deleteRoleMsg/{!! $role->userID !!}"><i class='material-icons'>Delete</i></a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
@endsection