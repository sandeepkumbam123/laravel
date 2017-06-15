@extends('layouts.portalLayout')
@section('content')

    <section class="content">
    <h1>
        Create exam
    </h1>
    <form method = 'get' action = '{!!url("portal/exam")!!}'>
        <button class = 'btn btn-danger'>exam Index</button>
    </form>
    <br>
    <form method = 'POST' action = '{!!url("portal/exam")!!}'>
        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
        <div class="form-group">
            <label for="class_names_classID">class_names_classID</label>
            <input id="class_names_classID" name = "class_names_classID" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="branches_branchID">branches_branchID</label>
            <input id="branches_branchID" name = "branches_branchID" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="subjectIDS">subjectIDS</label>
            <input id="subjectIDS" name = "subjectIDS" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="chapterIDS">chapterIDS</label>
            <input id="chapterIDS" name = "chapterIDS" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="exam_manualID">exam_manualID</label>
            <input id="exam_manualID" name = "exam_manualID" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="title">title</label>
            <input id="title" name = "title" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="critical_level">critical_level</label>
            <input id="critical_level" name = "critical_level" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="total_marks">total_marks</label>
            <input id="total_marks" name = "total_marks" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="pass_percentage">pass_percentage</label>
            <input id="pass_percentage" name = "pass_percentage" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="is_active">is_active</label>
            <input id="is_active" name = "is_active" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="exam_date">exam_date</label>
            <input id="exam_date" name = "exam_date" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="negative_mark">negative_mark</label>
            <input id="negative_mark" name = "negative_mark" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="duration">duration</label>
            <input id="duration" name = "duration" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="notes">notes</label>
            <input id="notes" name = "notes" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label for="questions">questions</label>
            <input id="questions" name = "questions" type="text" class="form-control">
        </div>
        <button class = 'btn btn-primary' type ='submit'>Create</button>
    </form>
</section>
@endsection