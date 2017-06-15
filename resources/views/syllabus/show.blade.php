@extends('layouts.portalLayout')

@section('content')

    <section class="content">
    <h1>
        Show syllabus
    </h1>
    <br>
    <form method = 'get' action = '{!!url("syllabus")!!}'>
        <button class = 'btn btn-primary'>syllabus Index</button>
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
                    <b><i>syllabus : </i></b>
                </td>
                <td>{!!$syllabus->syllabus!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>createdby : </i></b>
                </td>
                <td>{!!$syllabus->createdby!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection