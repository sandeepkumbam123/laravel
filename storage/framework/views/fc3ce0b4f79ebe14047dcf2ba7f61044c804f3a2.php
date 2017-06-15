<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            Edit Exam
        </h1>
        <form method='get' action='<?php echo url("portal/exam-list"); ?>'>
            <button class='btn btn-danger'>Show All Exams</button>
        </form>
        <br>
        <form method='POST' action='<?php echo url("portal/editexam-stepone"); ?>'>
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>


            <div class="form-group has-feedback <?php echo e($errors->has('title') ? ' has-error' : ''); ?>">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" class="form-control" value="<?php echo e(old('title',$exam->title)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('title')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('title')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('branches_branchID') ? ' has-error' : ''); ?>">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    <?php $__currentLoopData = $all_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->branchID); ?>"
                                <?php if(old('branches_branchID',$exam->branches_branchID) == $branch->branchID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($branch->branch_name)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('branches_branchID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('branches_branchID')); ?></strong>
                    </span>

                <?php endif; ?>

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="<?php echo e(Session::get('branch_id')); ?>">
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


            <div class="form-group has-feedback <?php echo e($errors->has('subjectIDS') ? ' has-error' : ''); ?>">
                <label for="subject">Subject</label>

                <select id="subject_name" name="subjectIDS[]" class="form-control" multiple data-domulti="yes">


                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('subjectIDS')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('subjectIDS')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('chapterIDS') ? ' has-error' : ''); ?>">
                <label for="chapterIDS">Chapter</label>

                <select id="chapter_name" name="chapterIDS[]" class="form-control" multiple data-domulti="yes">


                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('chapterIDS')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('chapterIDS')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('exam_date') ? ' has-error' : ''); ?>">
                <label for="exam_date">Exam Date</label>
                <input id="exam_date" name="exam_date" type="date" class="form-control" value="<?php echo e(old('exam_date',date("Y-m-d",strtotime(str_replace("-","/",$exam->exam_date))))); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('exam_date')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('exam_date')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('exam_manualID') ? ' has-error' : ''); ?>">
                <label for="exam_manualID">Exam ID</label>
                <input id="exam_manualID" name="exam_manualID" type="text" class="form-control" value="<?php echo e(old('exam_manualID', $exam->exam_manualID)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('exam_manualID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('exam_manualID')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('critical_level') ? ' has-error' : ''); ?>">

                <select id="critical_level" name="critical_level" class="form-control">
                    <option value="">Select A Critical Level</option>
                    <?php $__currentLoopData = $critical_level; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"
                                <?php if(old('critical_level',$exam->critical_level) == $key): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($value)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('critical_level')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('critical_level')); ?></strong>
                    </span>

                <?php endif; ?>

            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('total_marks') ? ' has-error' : ''); ?>">
                <label for="total_marks">Total Marks</label>
                <input id="total_marks" name="total_marks" type="number" class="form-control" value="<?php echo e(old('total_marks',$exam->total_marks)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('total_marks')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('total_marks')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('pass_percentage') ? ' has-error' : ''); ?>">
                <label for="pass_percentage">Pass Percentage</label>
                <input id="pass_percentage" name="pass_percentage" type="number" class="form-control" value="<?php echo e(old('pass_percentage',$exam->pass_percentage)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('pass_percentage')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('pass_percentage')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('negative_mark') ? ' has-error' : ''); ?>">
                <label for="negative_mark">Negative Mark</label>
                <input id="negative_mark" name="negative_mark" type="number" class="form-control" value="<?php echo e(old('negative_mark',$exam->negative_mark)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('negative_mark')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('negative_mark')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('duration') ? ' has-error' : ''); ?>">
                <label for="duration">Duration(In Minutes)</label>
                <input id="duration" name="duration" type="number" class="form-control" value="<?php echo e(old('duration',$exam->duration)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('duration')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('duration')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('notes') ? ' has-error' : ''); ?>">
                <label for="notes">Notes</label>

                <textarea id="notes" name="note" rows="6" class="form-control"><?php echo e(old('note',$exam->note)); ?></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('note')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('note')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <button class='btn btn-primary' type='submit'>Update</button>
            <input type="hidden" name="old_questions" value='<?php echo $exam->questions ?>'>
            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', $exam->branches_branchID); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID', $exam->class_names_classID); ?>">
            <input type="hidden" id="old_subject" value='<?php echo json_encode(old('subjectIDS', $exam->subjectIDS)); ?>'>
            <input type="hidden" id="old_chapter" value='<?php echo json_encode(old('chapterIDS', $exam->chapterIDS)); ?>'>
            <input type="hidden" name="examID" value="<?php echo $exam->examID ?>">

        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>