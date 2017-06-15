@extends('layouts.portalLayout')

@section('content')

    <section class="content">
    <h1>
        Syllabus
    </h1>
    <form class = 'col s3' method = 'get' action = '{!!url("portal/syllabus")!!}/create'>
        <button class = 'btn btn-primary' type = 'submit'>Create New syllabus</button>
    </form>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Syllabus</th>

            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($syllabuses as $syllabus) 
            <tr>
                <td>{!!$syllabus->syllabus!!}</td>

                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/portal/syllabus/{!!$syllabus->syllabuseID!!}/deleteMsg" ><i class = 'material-icons'>Delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/portal/syllabus/{!!$syllabus->syllabuseID!!}/edit'><i class = 'material-icons'>Edit</i></a>

                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>
    {!! $syllabuses->render() !!}

</section>
@endsection