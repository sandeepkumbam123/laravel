@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            All Branches
        </h1>
        <form class='col s3' method='get' action='{!!url("portal/branch")!!}/create'>
            <button class='btn btn-primary' type='submit'>Create New branch</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff'>
            <thead>
            <th>ID</th>
            <th>Branch name</th>
            <th>Syllabus</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($branches as $branch)
                <tr>
                    <td>{!!$branch->branchID!!}</td>
                    <td>{!!$branch->branch_name!!}</td>
                    <td>{!!$branch->syllabus!!}</td>
                    <td>{!!$branch->email!!}</td>
                    <td>{!!$branch->contact!!}</td>
                    <td style="width: 180px;">{!!$branch->address!!}</td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/branch/{!!$branch->branchID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/branch/{!!$branch->branchID!!}/edit'><i class='material-icons'>Edit</i></a>
                        <a href='#' class='viewShow btn btn-warning btn-xs' data-link='/portal/branch/{!!$branch->branchID!!}'><i class='material-icons'>Info</i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


    </section>
@endsection