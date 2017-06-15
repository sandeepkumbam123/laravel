@extends('layouts.portalLayout')
@section('content')

<section class="content">
    <h1>
        Show section
    </h1>
    <br>
    <form method = 'get' action = '{!!url("portal/section")!!}'>
        <button class = 'btn btn-primary'>Show All Section</button>
    </form>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Field</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>Class </i></b>
                </td>
                <td>{!!$section->class_names_classID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>Section </i></b>
                </td>
                <td>{!!$section->section_name!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection