@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            All Sections
        </h1>
        <form class='col s3' method='get' action='{!!url("portal/section")!!}/create'>
            <button class='btn btn-primary' type='submit'>Create New section</button>
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
            <th>Section</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($sections as $section)
                <tr>
                    <td>{{$section->sectionID}}</td>
                    @if(Session::get('role_name') == $const_role_name)
                        <td>{!!$section->branch_name!!}</td>
                    @endif
                    <td>{!!$section->class_name!!}</td>
                    <td>{!!$section->section_name!!}</td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/section/{!!$section->sectionID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/section/{!!$section->sectionID!!}/edit'><i class='material-icons'>Edit</i></a>
                        {{--<a href='#' class='viewShow btn btn-warning btn-xs' data-link='/portal/section/{!!$section->sectionID!!}'><i class='material-icons'>Info</i></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
@endsection