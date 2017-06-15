@extends('layouts.portalLayout')
@section('content')

    <section class="content">
        <h1>
            Edit Subject
        </h1>
        <form method='get' action='{!!url("portal/subject")!!}'>
            <button class='btn btn-danger'>subject Index</button>
        </form>
        <br>
        <form method='POST' action='{!! url("portal/subject")!!}/{!!$subject->
        subjectID!!}/update'>
            <input type='hidden' name='_token' value='{{Session::token()}}'>

            <div class="form-group has-feedback {{ $errors->has('branches_branchID') ? ' has-error' : '' }}">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    @foreach($all_branches  as $branch)
                        <option value="{{ $branch->branchID }}"
                                @if (old('branches_branchID',$subject->branches_branchID) == $branch->branchID) selected="selected" @endif>{{ ucfirst($branch->branch_name) }}</option>

                    @endforeach
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('branches_branchID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('branches_branchID') }}</strong>
                    </span>

                @endif

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="{{$subject->branches_branchID}}">
                <?php } ?>

            </div>


            <div class="form-group has-feedback {{ $errors->has('class_names_classID') ? ' has-error' : '' }}">
                <label for="subject">Class</label>

                <select id="class_name" name="class_names_classID" class="form-control">
                    <option value="">Select A Class</option>

                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('class_names_classID'))
                    <span class="help-block">
                        <strong>{{ $errors->first('class_names_classID') }}</strong>
                    </span>
                @endif
            </div>


            <div class="form-group has-feedback {{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="subject">Subject</label>
                <input id="subject" name="subject" type="subject" class="form-control" value="{{old('subject',$subject->
            subject)}}" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                @if ($errors->has('subject'))
                    <span class="help-block">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
            </div>


            <button class='btn btn-primary' type='submit'>Update</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', $subject->branches_branchID); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID', $subject->class_names_classID); ?>">


        </form>
    </section>
@endsection
@section('page_scripts')
    <script>
        $(function () {
            var old_branch = $("#old_branch").val();
            if (old_branch) {
                if ($("#branches_branchID").length) {
                    $('#branches_branchID').trigger('change');
                    $("#branches_branchID").trigger("chosen:updated");
                } else {
                    update_class_dropdown(old_branch);
                }
            }
        });
        $("#branches_branchID").on("change", function () {

            $('#class_name').empty().append('<option selected="selected" value="">Select A Subject</option>');


            var branch_id = $(this).val();
            update_class_dropdown(branch_id);

        })


        function update_class_dropdown(branch_id) {
            if (branch_id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: base_URL + "/secure/get_avil_classes",
                    data: {_token: $("#_token").val(), branch_id: branch_id},
                    dataType: "json"
                }).done(function (resultData) {

                    $.each(resultData, function (i, item) {
                        $('#class_name').append($('<option>', {
                            value: item.classID,
                            text: item.class_name
                        }));
                    });
                })
                        .fail(function (error) {
                            console.error(error);
                        })
                        .always(function () {

                            if ($("#old_branch").val() != '' && $("#old_branch").val() != null) {

                                if ($("#old_branch").val()) {
                                    $('#class_name').val($("#old_class").val());
                                    $("#class_name").trigger("chosen:updated");
                                }


                            }
                        });
            }
        }


    </script>
@endsection