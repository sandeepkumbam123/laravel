@extends('layouts.portalLayout')
@section('content')

    <section class="content">
    <h1>
        Show exam
    </h1>
    <br>
    <form method = 'get' action = '{!!url("portal/exam")!!}'>
        <button class = 'btn btn-primary'>exam Index</button>
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
                <td>{!!$exam->class_names_classID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>branches_branchID : </i></b>
                </td>
                <td>{!!$exam->branches_branchID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>subjectIDS : </i></b>
                </td>
                <td>{!!$exam->subjectIDS!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>chapterIDS : </i></b>
                </td>
                <td>{!!$exam->chapterIDS!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>exam_manualID : </i></b>
                </td>
                <td>{!!$exam->exam_manualID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>title : </i></b>
                </td>
                <td>{!!$exam->title!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>critical_level : </i></b>
                </td>
                <td>{!!$exam->critical_level!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>total_marks : </i></b>
                </td>
                <td>{!!$exam->total_marks!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>pass_percentage : </i></b>
                </td>
                <td>{!!$exam->pass_percentage!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>is_active : </i></b>
                </td>
                <td>{!!$exam->is_active!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>exam_date : </i></b>
                </td>
                <td>{!!$exam->exam_date!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>negative_mark : </i></b>
                </td>
                <td>{!!$exam->negative_mark!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>duration : </i></b>
                </td>
                <td>{!!$exam->duration!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>notes : </i></b>
                </td>
                <td>{!!$exam->notes!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>questions : </i></b>
                </td>
                <td>{!!$exam->questions!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection