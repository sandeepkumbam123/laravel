@extends('layouts.portalLayout')

@section('content')
    <section class="content">
        <h1>
            Select Questions
        </h1>


        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif


        <form method='get' action='{!!url("portal/search-questions")!!}'>
            <button class='btn btn-danger'>Go Back</button>
        </form>
        <br>
        <form onsubmit="return validate_question()" method='POST' action='{!!url("portal/create-exam")!!}' class="form-inline">
            <input type='hidden' name='_token' value='{{Session::token()}}'>
            <table class="table table-striped  table-bordered table-inverse">
                <tr>
                    <td>Exam ID</td>
                    <td>
                        {{$input_data["exam_manualID"]}}
                        <input type="hidden" name="exam_manualID" value="{{$input_data["exam_manualID"]}}">
                    </td>

                    <td>Exam Title</td>
                    <td>
                        {{$input_data["title"]}}
                        <input type="hidden" name="title" value="{{$input_data["title"]}}">
                    </td>


                </tr>

                <tr>
                    <td>Class</td>
                    <td>
                        {{$class_data->class_name}}
                        <input type="hidden" name="class_names_classID" value="<?php echo $class_data->classID ?>">
                    </td>


                    <td>Critical level</td>
                    <td>
                        {{$critical_level[$input_data["critical_level"]]}}
                        <input type="hidden" name="critical_level" value="{{$input_data["critical_level"]}}">
                    </td>


                </tr>

                <tr>
                    <td>Chapters</td>
                    <td colspan="3">

                        <ul class="list-group">
                            <?php foreach ($input_data["chapterIDS"] as $chapter){?>
                            <li class="list-group-item list-group-item-success">{{$chapter_list[$chapter]}}</li>
                            <input name="chapterIDS[]" type="hidden" value="{{$chapter}}">
                            <?php }?>
                        </ul>
                    </td>

                </tr>


                <tr>
                    <td>Subjects</td>
                    <td colspan="3">

                        <ul class="list-group">
                            <?php foreach ($input_data["subjectIDS"] as $subject){?>
                            <li class="list-group-item list-group-item-warning">{{$subject_list[$subject]}}</li>
                            <input name="subjectIDS[]" type="hidden" value="{{$subject}}">
                            <?php }?>
                        </ul>
                    </td>


                </tr>
                <tr>

                    <td>Total Mark</td>
                    <td>{{$input_data["total_marks"]}}
                        <input type="hidden" name="total_marks" value="{{$input_data["total_marks"]}}">
                    </td>
                    <td>Pass Percentage</td>
                    <td>{{$input_data["pass_percentage"]}}
                        <input type="hidden" name="pass_percentage" value="{{$input_data["pass_percentage"]}}">
                    </td>

                </tr>


                <tr>
                    <td>Date</td>
                    <td>{{$input_data["exam_date"]}}
                        <input type="hidden" name="exam_date" value="{{$input_data["exam_date"]}}">
                    </td>


                    <td>Negative Marks</td>
                    <td>{{$input_data["negative_mark"]}}
                        <input type="hidden" name="negative_mark" value="{{$input_data["negative_mark"]}}">
                    </td>
                </tr>

                <tr>
                    <td>Duration</td>
                    <td>
                        {{$input_data["duration"]}}
                        <input type="hidden" name="duration" value="{{$input_data["duration"]}}">
                    </td>
                    <td></td>
                    <td></td>

                </tr>
            </table>

            <br>
            <hr>
            <br>


            <span class="help-block has-error" style="color: #a94442 !important;" id="q_error"></span>

            <table class="table table-striped" id="example">
                <thead>
                <th>Select</th>
                <th>Questions</th>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Marks</th>
                <th>Critical</th>


                </thead>
                @foreach($questions as $question)
                    <tr>
                        <td><input class="question_check" type="checkbox" data-ques_mark="{{$question->mark}}" name="selected_questions[]" value="<?php echo $question->questionID; ?>"></td>

                        <td><?php
                            if($question->is_image=='yes'){
                            ?><img src="{!!  asset("public".$question->question) !!}" height="100" width="100">

                            <?php }else{?>
                            {!!$question->question!!}
                            <?php }?>

                        </td>

                        <td>{{$question->subject}}</td>
                        <td>{{$question->chapter}}</td>
                        <td>{{$question->mark}}</td>
                        <td>{{$critical_level[$question->critical_level]}}</td>
                    </tr>
                @endforeach

            </table>

            <button id="submit_btn" class='btn btn-primary' type='submit'>Submit</button>
            <br/> <br/>
            <input type="hidden" id="total_marks" value=" {{$input_data["total_marks"]}}">
            <input type="hidden" name="branches_branchID" value=" {{$input_data["branches_branchID"]}}">

        </form>
    </section>

@endsection

@section('page_scripts')
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
            });

        });

        function validate_question() {
            if ($('input[name="selected_questions[]"]:checked').length < 1) {
                $("#q_error").html("<h3 style='color: #a94442 !important;'>Please select Questions</h3><br>");


                return false;
            }
            if(current_total< total_marks){
                $("#submit_btn").prop('disabled', true);
                $("#q_error").html("<h3 style='color: #a94442 !important;'>It's looks like you have to select few more questions </h3><br>");
                return false;
            }
        }

        var total_marks=$("#total_marks").val();
        var current_total=0;
        $(".question_check").on("change",function () {
            var this_q_mark=$(this).data("ques_mark");
            if(this.checked) {
                current_total+=this_q_mark;
            }else{
                current_total-=this_q_mark;
            }

            if(current_total>total_marks){
               $("#submit_btn").prop('disabled', true);
                $("#q_error").html("<h3 style='color: #a94442 !important;'>It's looks like you have to un-check few  questions  </h3><br>");
            }
            if(current_total==total_marks){
                $("#submit_btn").prop('disabled', false);
            }
        });



    </script>
@endsection