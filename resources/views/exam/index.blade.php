@extends('layouts.portalLayout')
<?php use App\Http\Controllers\ExamController; ?>
@section('content')

    <section class="content">
        <h1>
            All Exams
        </h1>

        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif
        <form class='col s3' method='get' action='{!!url("portal/search-questions")!!}'>
            <button class='btn btn-primary' type='submit'>Create New exam</button>
            <a class='btn btn-primary '  href="{!!url("portal/exam/generate-exam")!!}" style="margin-left: 20%">Automated Exam</a>
            <a class='btn btn-primary pull-right' href="{!!url("portal/exam/upload")!!}">Upload Exam</a>

        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff' id="data_table">
            <thead>
            @if(Session::get('role_name') == $const_role_name)
                <th>Branch</th>
            @endif
            <th>Title</th>
            <th>Class</th>
            <th>Subjects</th>
            <th>Exam ID</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($exams as $exam)
                <tr>
                    @if(Session::get('role_name') == $const_role_name)
                        <td>{!!ucfirst($exam->branch_name)!!}</td>
                    @endif
                    <td>{!!ucfirst($exam->title)!!}</td>
                    <td>{!!ucfirst($exam->class_name)!!}</td>


                    <td><?php
                        $subs = explode(",", $exam->subjectIDS);
                        foreach ($subs as $subId) {
                            $sub_data = ExamController::objArraySearch($subjects, "subjectID", $subId);
                            echo $sub_data->subject . "<br>";
                        }

                        ?></td>
                    <td>{!!$exam->exam_manualID!!}</td>
                    <td>{!!$exam->is_active=="true" ? "Active": "Inactive"!!}</td>
                    <td>{!! date("d-m-Y",strtotime($exam->exam_date)) !!}</td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/exam/{!!$exam->examID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/editexam-stepone/{!!$exam->examID!!}/edit'><i class='material-icons'>Edit</i></a>
                        {{--<a href='#' class='viewShow btn btn-warning btn-xs' data-link='/portal/exam/{!!$exam->examID!!}'><i class='material-icons'>Info</i></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
@endsection