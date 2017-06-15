@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Chapters
        </h1>
        <form class='col s3' method='get' action='{!!url("portal/chapter")!!}/create'>
            <button class='btn btn-primary' type='submit'>Create New chapter</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff' id="data_table">
            <thead>
            <th>ID</th>
            @if(Session::get('role_name') == $const_role_name)
                <th>Branch</th>
                <th>Class</th>
            @endif
            <th>Subject</th>
            <th>Chapter</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($chapters as $chapter)
                <tr>
                    <td>{{$chapter->chapterID}}</td>
                    @if(Session::get('role_name') == $const_role_name)
                        <td>{!!$chapter->branch_name!!}</td>
                        <td>{!!$chapter->class_name!!}</td>
                    @endif
                    <td>{!!$chapter->subject!!}</td>
                    <td>{!!$chapter->chapter!!}</td>
                    <td style="width: 150px">
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/chapter/{!!$chapter->chapterID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/chapter/{!!$chapter->chapterID!!}/edit'><i class='material-icons'>Edit</i></a>
                        {{-- <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/portal/chapter/{!!$chapter->chapterID!!}'><i class = 'material-icons'>info</i></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection

@section('page_scripts')
    @if(Session::get('role_name') == $const_role_name)
    <script>
        /*$(document).ready(function () {
            $('#data_table').DataTable( {
                "paging":   true,
                "ordering": true,
                "info":     false,
            } );

        });*/
    </script>
    @endif
@endsection