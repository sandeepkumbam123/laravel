@extends('layouts.portalLayout')
@section('content')

    <section class="content">
    <h1>
        Show chapter
    </h1>
    <br>
    <form method = 'get' action = '{!!url("chapter")!!}'>
        <button class = 'btn btn-primary'>chapter Index</button>
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
                    <b><i>subjects_subjectID : </i></b>
                </td>
                <td>{!!$chapter->subjects_subjectID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>chapter : </i></b>
                </td>
                <td>{!!$chapter->chapter!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection