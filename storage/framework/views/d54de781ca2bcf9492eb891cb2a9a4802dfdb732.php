<?php $__env->startSection('content'); ?>
    <section class="content">
        <h1>
            Select Questions
        </h1>


        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>


        <form method='get' action='<?php echo url("portal/search-questions"); ?>'>
            <button class='btn btn-danger'>Go Back</button>
        </form>
        <br>
        <form onsubmit="return validate_question()" method='POST' action='<?php echo url("portal/create-exam"); ?>' class="form-inline">
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>
            <table class="table table-striped  table-bordered table-inverse">
                <tr>
                    <td>Exam ID</td>
                    <td>
                        <?php echo e($input_data["exam_manualID"]); ?>

                        <input type="hidden" name="exam_manualID" value="<?php echo e($input_data["exam_manualID"]); ?>">
                    </td>

                    <td>Exam Title</td>
                    <td>
                        <?php echo e($input_data["title"]); ?>

                        <input type="hidden" name="title" value="<?php echo e($input_data["title"]); ?>">
                    </td>


                </tr>

                <tr>
                    <td>Class</td>
                    <td>
                        <?php echo e($class_data->class_name); ?>

                        <input type="hidden" name="class_names_classID" value="<?php echo $class_data->classID ?>">
                    </td>


                    <td>Critical level</td>
                    <td>
                        <?php echo e($critical_level[$input_data["critical_level"]]); ?>

                        <input type="hidden" name="critical_level" value="<?php echo e($input_data["critical_level"]); ?>">
                    </td>


                </tr>

                <tr>
                    <td>Chapters</td>
                    <td colspan="3">

                        <ul class="list-group">
                            <?php foreach ($input_data["chapterIDS"] as $chapter){?>
                            <li class="list-group-item list-group-item-success"><?php echo e($chapter_list[$chapter]); ?></li>
                            <input name="chapterIDS[]" type="hidden" value="<?php echo e($chapter); ?>">
                            <?php }?>
                        </ul>
                    </td>

                </tr>


                <tr>
                    <td>Subjects</td>
                    <td colspan="3">

                        <ul class="list-group">
                            <?php foreach ($input_data["subjectIDS"] as $subject){?>
                            <li class="list-group-item list-group-item-warning"><?php echo e($subject_list[$subject]); ?></li>
                            <input name="subjectIDS[]" type="hidden" value="<?php echo e($subject); ?>">
                            <?php }?>
                        </ul>
                    </td>


                </tr>
                <tr>

                    <td>Total Mark</td>
                    <td><?php echo e($input_data["total_marks"]); ?>

                        <input type="hidden" name="total_marks" value="<?php echo e($input_data["total_marks"]); ?>">
                    </td>
                    <td>Pass Percentage</td>
                    <td><?php echo e($input_data["pass_percentage"]); ?>

                        <input type="hidden" name="pass_percentage" value="<?php echo e($input_data["pass_percentage"]); ?>">
                    </td>

                </tr>


                <tr>
                    <td>Date</td>
                    <td><?php echo e($input_data["exam_date"]); ?>

                        <input type="hidden" name="exam_date" value="<?php echo e($input_data["exam_date"]); ?>">
                    </td>


                    <td>Negative Marks</td>
                    <td><?php echo e($input_data["negative_mark"]); ?>

                        <input type="hidden" name="negative_mark" value="<?php echo e($input_data["negative_mark"]); ?>">
                    </td>
                </tr>

                <tr>
                    <td>Duration</td>
                    <td>
                        <?php echo e($input_data["duration"]); ?>

                        <input type="hidden" name="duration" value="<?php echo e($input_data["duration"]); ?>">
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
                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input class="question_check" type="checkbox" data-ques_mark="<?php echo e($question->mark); ?>" name="selected_questions[]" value="<?php echo $question->questionID; ?>"></td>

                        <td><?php
                            if($question->is_image=='yes'){
                            ?><img src="<?php echo asset("public".$question->question); ?>" height="100" width="100">

                            <?php }else{?>
                            <?php echo $question->question; ?>

                            <?php }?>

                        </td>

                        <td><?php echo e($question->subject); ?></td>
                        <td><?php echo e($question->chapter); ?></td>
                        <td><?php echo e($question->mark); ?></td>
                        <td><?php echo e($critical_level[$question->critical_level]); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </table>

            <button id="submit_btn" class='btn btn-primary' type='submit'>Submit</button>
            <br/> <br/>
            <input type="hidden" id="total_marks" value=" <?php echo e($input_data["total_marks"]); ?>">
            <input type="hidden" name="branches_branchID" value=" <?php echo e($input_data["branches_branchID"]); ?>">

        </form>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>