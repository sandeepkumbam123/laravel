@extends('layouts.portalLayout')
@section('content')

<section class="content">
    <h1>
        Show subject
    </h1>
    <br>
    <form method = 'get' action = '{!!url("subject")!!}'>
        <button class = 'btn btn-primary'>subject Index</button>
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
                    <b><i>class_names_classID : </i></b>
                </td>
                <td>{!!$subject->class_names_classID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>subject : </i></b>
                </td>
                <td>{!!$subject->subject!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection