@extends('layouts.portalLayout')
@section('content')

    <section class="content">
    <h1>
        Questions
    </h1>
    <form class = 'col s3' method = 'get' action = '{!!url("portal/question")!!}/create'>
        <button class = 'btn btn-primary' type = 'submit'>Create New Question</button>
        <a class = 'btn btn-primary pull-right' href={!!url("portal/upload-question/")!!}>Upload Questions</a>
    </form>


    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" cellspacing="0" width="100%" style = 'background:#fff' id="data_table">
        <thead>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Class</th>
            <th>Question</th>
            <th>Mark</th>
            <th>Critical</th>
            <th>Actions</th>
        </thead>
        <tbody>
            @foreach($questions as $question) 
            <tr>
                <td>{!!$question->subject!!}</td>
                <td>{!!$question->chapter!!}</td>
                <td>{!!$question->class_name!!}</td>

                <td><?php
                    if($question->is_image=='yes'){
                    ?><img src="{!!  asset("public".$question->question) !!}" height="100" width="100">

                <?php }else{?>
                    {!!$question->question!!}
                    <?php }?>

                </td>

                <td>{!!$question->mark!!}</td>
                <td>{!!$critical_level[$question->critical_level]!!}</td>

                <td style="width:200px">
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/portal/question/{!! $question->questionID !!}/deleteMsg" ><i class = 'material-icons'>Delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/portal/question/{!!$question->questionID!!}/edit'><i class = 'material-icons'>Edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/portal/question/{!!$question->questionID!!}'><i class = 'material-icons'>Info</i></a>
                </td>
            </tr>
            @endforeach 
        </tbody>
    </table>


</section>
@endsection