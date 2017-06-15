@extends('layouts.portalLayout')
@section('content')

<section class="content">
    <h1>
        Subjects
    </h1>
    <form class = 'col s3' method = 'get' action = '{!!url("portal/subject")!!}/create'>
        <button class = 'btn btn-primary' type = 'submit'>Create New Subject</button>
    </form>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
        <th>ID</th>
            <th>Class</th>
            <th>Subject</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($subjects as $subject)

            <tr>
                <td>{{$subject->subjectID}}</td>
                <td>{!!$subject->class_name!!}</td>
                <td>{!!$subject->subject!!}</td>
                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/portal/subject/{!!$subject->subjectID!!}/deleteMsg" ><i class = 'material-icons'>Delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/portal/subject/{!!$subject->subjectID!!}/edit'><i class = 'material-icons'>Edit</i></a>
                    {{--<a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/portal/subject/{!!$subject->subjectID!!}'><i class = 'material-icons'>Info</i></a>--}}
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>


</section>
@endsection