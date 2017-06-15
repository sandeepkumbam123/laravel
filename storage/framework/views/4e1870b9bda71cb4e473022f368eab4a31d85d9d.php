<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            Edit Question
        </h1>
        <form method='get' action='<?php echo url("portal/question"); ?>'>
            <button class='btn btn-danger'>Show All Question</button>
        </form>
        <br>
        <form method='POST' action='<?php echo url("portal/question"); ?>/<?php echo $question->
        questionID; ?>/update' id="edit_question" enctype="multipart/form-data">

            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>

            <div class="form-group has-feedback <?php echo e($errors->has('branches_branchID') ? ' has-error' : ''); ?>">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    <?php $__currentLoopData = $all_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->branchID); ?>"
                                <?php if(old('branches_branchID',$question->branchID) == $branch->branchID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($branch->branch_name)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('branches_branchID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('branches_branchID')); ?></strong>
                    </span>

                <?php endif; ?>

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="<?php echo e($chapter->branchID); ?>">
                <?php } ?>

            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('class_names_classID') ? ' has-error' : ''); ?>">
                <label for="subject">Class</label>

                <select id="class_name" name="class_names_classID" class="form-control">
                    <option value="">Select A Class</option>

                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('class_names_classID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('class_names_classID')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('subjects_subjectID') ? ' has-error' : ''); ?>">
                <label for="subject">Subject</label>

                <select id="subject_name" name="subjects_subjectID" class="form-control">
                    <option value="">Select A Subject</option>

                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('subjects_subjectID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('subjects_subjectID')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('chapters_chapterID') ? ' has-error' : ''); ?>">
                <label for="chapters_chapterID">Chapter</label>

                <select id="chapter_name" name="chapters_chapterID" class="form-control">
                    <option value="">Select A Chapter</option>

                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('chapters_chapterID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('chapters_chapterID')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('question') ? ' has-error' : ''); ?>">
                <label for="question">Question</label>

                <textarea id="question" name="question" rows="6" class="form-control" <?php if($question->is_image == 'yes' ){?>style="display: none" <?php } ?> onchange="update_hidden('image_question_edit')">   <?php if($question->is_image == 'no'){?><?php echo e(old('question',$question->question)); ?><?php } ?></textarea>
                <br/>
                <input type="file" name="image_question" id="image_question" <?php if($question->is_image == 'yes'){?>style="display: none" <?php } ?> onchange="update_hidden('image_question_edit')">
                <br/>
                <input type="hidden" value="no" name="image_question_edit" id="image_question_edit">

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                <?php if($question->is_image == 'yes'){?>
                <br>
                <div class="profile-pic image_question">
                    <img src="<?php echo e(asset("public".$question->question)); ?>" height="200"
                         width="200">
                    <div class="edit delete_image"><i class="fa fa-pencil fa-lg"></i></div>
                </div>
                <br>
                <?php } ?>

                <?php if($errors->has('question')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('question')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('mark') ? ' has-error' : ''); ?>">
                <label for="mark">Mark</label>
                <input id="mark" name="mark" type="number" class="form-control" value="<?php echo e(old('mark',$question->mark)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('mark')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('mark')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('critical_level') ? ' has-error' : ''); ?>">

                <select id="critical_level" name="critical_level" class="form-control">
                    <option value="">Select A Critical Level</option>
                    <?php $__currentLoopData = $critical_level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"
                                <?php if(old('critical_level',$question->critical_level) == $key): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($value)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('critical_level')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('critical_level')); ?></strong>
                    </span>

                <?php endif; ?>

            </div>


            <hr>
            <h4>Question's Options</h4>
            <hr>
            <div class="form-group has-feedback <?php echo e($errors->has('option1') ? ' has-error' : ''); ?>">
                <label for="option1">Option-1</label>
                <textarea id="option1" class="form-control" name="option1" <?php if($question->is_option1_image == 'yes' ){?>style="display: none" <?php } ?> onchange="update_hidden('image_option1_edit')"><?php if($question->is_option1_image == 'no'){?><?php echo e(old('option1',$question->option1)); ?> <?php } ?></textarea>

                <br/>
                <input type="file" name="option1_image" id="option1_image" <?php if($question->is_option1_image == 'yes'){?>style="display: none" <?php } ?> onchange="update_hidden('image_option1_edit')">
                <br/>
                <input type="hidden" value="no" name="image_option1_edit" id="image_option1_edit">


                <?php if($question->is_option1_image == 'yes'){?>
                <br>
                <div class="profile-pic">
                    <img src="<?php echo e(asset("public".$question->option1)); ?>" height="200"
                         width="200">
                    <div class="edit image_option" data-to_update="image_option1_edit" data-to_show="option1" data-to_show1="option1_image"><i class="fa fa-pencil fa-lg"></i></div>
                </div>
                <br>
                <?php } ?>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('option1')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('option1')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('option2') ? ' has-error' : ''); ?>">
                <label for="option2">Option-2</label>
                <textarea id="option2" class="form-control" name="option2" <?php if($question->is_option2_image == 'yes' ){?>style="display: none" <?php } ?>  onchange="update_hidden('image_option2_edit')"><?php if($question->is_option2_image == 'no'){?><?php echo e(old('option2',$question->option2)); ?> <?php } ?></textarea>

                <br/>
                <input type="file" name="option2_image" id="option2_image" <?php if($question->is_option2_image == 'yes'){?>style="display: none" <?php } ?> onchange="update_hidden('image_option2_edit')">
                <br/>
                <input type="hidden" value="no" name="image_option2_edit" id="image_option2_edit">


                <?php if($question->is_option2_image == 'yes'){?>
                <br>
                <div class="profile-pic">
                    <img src="<?php echo e(asset("public".$question->option2)); ?>" height="200"
                         width="200">
                    <div class="edit image_option" data-to_update="image_option2_edit" data-to_show="option2" data-to_show1="option2_image"><i class="fa fa-pencil fa-lg"></i></div>
                </div>
                <br>
                <?php } ?>


                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('option2')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('option2')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('option3') ? ' has-error' : ''); ?>">
                <label for="option3">Option-3</label>
                <textarea id="option3" class="form-control" name="option3" <?php if($question->is_option3_image == 'yes' ){?>style="display: none" <?php } ?>  onchange="update_hidden('image_option3_edit')"><?php if($question->is_option3_image == 'no'){?><?php echo e(old('option3',$question->option3)); ?> <?php } ?></textarea>

                <br/>
                <input type="file" name="option3_image" id="option3_image" <?php if($question->is_option3_image == 'yes'){?>style="display: none" <?php } ?>  onchange="update_hidden('image_option3_edit')">
                <br/>
                <input type="hidden" value="no" name="image_option3_edit" id="image_option3_edit">


                <?php if($question->is_option3_image == 'yes'){?>
                <br>
                <div class="profile-pic">
                    <img src="<?php echo e(asset("public".$question->option3)); ?>" height="200"
                         width="200">
                    <div class="edit image_option" data-to_update="image_option3_edit" data-to_show="option3" data-to_show1="option3_image"><i class="fa fa-pencil fa-lg"></i></div>
                </div>
                <br>
                <?php } ?>


                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('option3')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('option3')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('option4') ? ' has-error' : ''); ?>">
                <label for="option4">Option-4</label>
                <textarea id="option4" class="form-control" name="option4" <?php if($question->is_option4_image == 'yes' ){?>style="display: none" <?php } ?> onchange="update_hidden('image_option4_edit')"><?php if($question->is_option4_image == 'no'){?><?php echo e(old('option4',$question->option4)); ?> <?php } ?></textarea>

                <br/>
                <input type="file" name="option4_image" id="option4_image" <?php if($question->is_option4_image == 'yes'){?>style="display: none" <?php } ?> onchange="update_hidden('image_option4_edit')">
                <br/>
                <input type="hidden" value="no" name="image_option4_edit" id="image_option4_edit">


                <?php if($question->is_option4_image == 'yes'){?>
                <br>
                <div class="profile-pic">
                    <img src="<?php echo e(asset("public".$question->option4)); ?>" height="200"
                         width="200">
                    <div class="edit image_option" data-to_update="image_option4_edit" data-to_show="option4" data-to_show1="option4_image"><i class="fa fa-pencil fa-lg"></i></div>
                </div>
                <br>
                <?php } ?>


                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('option4')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('option4')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('answer') ? ' has-error' : ''); ?>">

                <select id="answer" name="answer" class="form-control">
                    <option value="">Select An Answer</option>
                    <?php $__currentLoopData = $answer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"
                                <?php if(old('answer',$question->answer) == $key): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($value)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('answer')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('answer')); ?></strong>
                    </span>

                <?php endif; ?>

            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('notes') ? ' has-error' : ''); ?>">
                <label for="notes">Notes</label>
                <textarea id="notes" class="form-control" name="notes"><?php echo e(old('notes',$question->notes)); ?></textarea>


                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('notes')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('notes')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <button class='btn btn-primary' type='submit'>Update</button>
            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID', $question->class_names_classID); ?>">
            <input type="hidden" id="old_subject" value="<?php echo old('subjects_subjectID', $question->subjects_subjectID); ?>">
            <input type="hidden" id="old_chapter" value="<?php echo old('chapters_chapterID', $question->chapters_chapterID); ?>">


        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>

    <script>

        function update_hidden(id) {
            $("#" + id).val("yes");
        }

        $(".image_question").click(function (e) {
            e.preventDefault();

            $(".image_question").remove();
            $("#question").show();
            $("#image_question").show();
            $("#image_question_edit").val("yes");


            return false;

        });


        $(".image_option").click(function (e) {
            e.preventDefault();
            var to_show = $(this).data("to_show");
            var to_show1 = $(this).data("to_show1");
            var to_update = $(this).data("to_update");
            $(this).parent().remove();
            $("#" + to_show).show();
            $("#" + to_show1).show();
            $("#" + to_update).val("yes");


            return false;

        });


        $('#edit_question').submit(function (e) {

            var is_error = false;

            if (!$("#branches_branchID").val()) {
                $("#branches_branchID").parent().addClass("has-error");
                $('#branches_branchID').focus();
                is_error = true;
            }
            if (!$("#class_name").val()) {
                $("#class_name").parent().addClass("has-error");
                $('#class_name').focus();
                is_error = true;
            }
            if (!$("#subject_name").val()) {
                $("#subject_name").parent().addClass("has-error");
                $('#subject_name').focus();
                is_error = true;
            }

            if (!$("#chapter_name").val()) {
                $("#chapter_name").parent().addClass("has-error");
                $('#chapter_name').focus();
                is_error = true;
            }


            if ($("#image_question_edit").val() == 'yes') {
                if ($('#image_question').val() == '' && $('#question').val() == '') {

                    $("#image_question").parent().addClass("has-error");
                    $('#image_question').focus();
                    is_error = true;

                } else {
                    $("#image_question").parent().removeClass("has-error");
                }
            }

            if ($("#image_option1_edit").val() == 'yes') {
                if ($('#option1_image').val() == '' && $('#option1').val() == '') {
                    $("#image_option1_edit").parent().addClass("has-error");
                    $('#option1_image').focus();
                    is_error = true;

                } else {
                    $("#image_option1_edit").parent().removeClass("has-error");
                }
            }

            if ($("#image_option2_edit").val() == 'yes') {
                if ($('#option2_image').val() == '' && $('#option2').val() == '') {
                    $("#image_option2_edit").parent().addClass("has-error");
                    $('#option2_image').focus();
                    is_error = true;

                } else {
                    $("#image_option2_edit").parent().removeClass("has-error");
                }
            }

            if ($("#image_option3_edit").val() == 'yes') {
                if ($('#option3_image').val() == '' && $('#option3').val() == '') {
                    $("#image_option3_edit").parent().addClass("has-error");
                    $('#option3_image').focus();
                    is_error = true;
                } else {
                    $("#image_option3_edit").parent().removeClass("has-error");
                }
            }

            if ($("#image_option4_edit").val() == 'yes') {
                if ($('#option4_image').val() == '' && $('#option4').val() == '') {
                    $("#image_option4_edit").parent().addClass("has-error");
                    $('#option4_image').focus();
                    is_error = true;
                } else {
                    $("#image_option4_edit").parent().removeClass("has-error");
                }
            }
            if (is_error) {
                return false;
            }

        });
    </script>







<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>