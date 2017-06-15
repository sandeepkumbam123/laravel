@extends('layouts.portalLayout')
@section('content')

<section class="content">
    <h1>
        Show class_name
    </h1>
    <br>
    <form method = 'get' action = '{!!url("portal/class")!!}'>
        <button class = 'btn btn-primary'>class_name Index</button>
    </form>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>branches_branchID : </i></b>
                </td>
                <td>{!!$class_name->branches_branchID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>class_name : </i></b>
                </td>
                <td>{!!$class_name->class_name!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection