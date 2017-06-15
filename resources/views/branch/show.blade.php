@extends('layouts.portalLayout')
@section('title','Show')
@section('content')

    <section class="content">
        <h1>
            Show branch
        </h1>
        <br>
        <form method='get' action='{!!url("portal/branch")!!}'>
            <button class='btn btn-primary'>Show Branches</button>
        </form>
        <br>
        <table class='table table-bordered'>
            <thead>
            <th>Field</th>
            <th>Value</th>
            </thead>
            <tbody>


            <tr>
                <td>
                    <b><i>Branch Name : </i></b>
                </td>
                <td>{!!$branch->branch_name!!}</td>
            </tr>

            <tr>
                <td>
                    <b><i>Syllabus</i></b>
                </td>
                <td>{!!$branch->syllabus !!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>Email </i></b>
                </td>
                <td>{!!$branch->email!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>Contact</i></b>
                </td>
                <td>{!!$branch->contact!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>Address</i></b>
                </td>
                <td>{!!$branch->address!!}</td>
            </tr>
            </tbody>
        </table>
    </section>
@endsection