<?php $__env->startSection('content'); ?>
    <section class="content">
        <h1>
            Add Role To Teacher
        </h1>

        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>


        <form class='col s3' method='get' action='<?php echo url("portal/teacher"); ?>'>
            <button class='btn btn-primary' type='submit'>Show All Teachers</button>
            <a href="<?php echo url("portal/teacher/$id/roles"); ?>" class='btn btn-primary pull-right' type='submit'>Go Back</a>
        </form>

        <br>

        <form method='POST' action='<?php echo url("portal/teacher/saveRole"); ?>' id="" enctype="multipart/form-data">
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>

            <?php if($errors->has('is_valid')): ?>
                <span class="help-block has-error" style="color:red ">
                        <strong><?php echo e($errors->first('is_valid')); ?></strong>
                    </span>
                <br>
            <?php endif; ?>

            <div class="form-group has-feedback <?php echo e($errors->has('classID') ? ' has-error' : ''); ?>">

                <select id="classID" name="classID" class="form-control">
                    <option value="">Select A Class</option>
                    <?php $__currentLoopData = $class_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $this_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($this_class->classID); ?>"
                                <?php if(old('classID') == $this_class->classID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($this_class->class_name)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('classID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('classID')); ?></strong>
                    </span>

                <?php endif; ?>

                <div class="form-group has-feedback <?php echo e($errors->has('sectionID') ? ' has-error' : ''); ?>">
                    <label for="section">Section</label>

                    <select id="sectionID" name="sectionID" class="form-control">
                        <option value="">Select A Section</option>

                    </select>

                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <?php if($errors->has('sectionID')): ?>
                        <span class="help-block">
                        <strong><?php echo e($errors->first('sectionID')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>


                <div class="form-group has-feedback <?php echo e($errors->has('subjectID') ? ' has-error' : ''); ?>">
                    <label for="subjectID">Subjects</label>

                    <select id="subject_name" name="subjectID" class="form-control">
                        <option value="">Select A Subject</option>

                    </select>

                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    <?php if($errors->has('subjectID')): ?>
                        <span class="help-block">
                        <strong><?php echo e($errors->first('subjectID')); ?></strong>
                    </span>
                    <?php endif; ?>
                </div>


                <button class='btn btn-primary' type='submit'>Create</button>


                <input type="hidden" value="<?php echo $branch_id; ?>" id="old_branch">
                <input type="hidden" value="<?php echo old('sectionID'); ?>" id="old_section">
                <input type="hidden" value="<?php echo old('subjectID'); ?>" id="old_subject">
                <input type="hidden" name="userID" value="<?php echo $id; ?>">


            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page_scripts'); ?>
    <script>

        $(function () {
            var classID = $("#classID").val();
            var branch_id = $("#old_branch").val();

            if(classID){
                update_section_dropdown(branch_id, classID);
                update_subject_dropdown(branch_id, classID);
            }
            $("#classID").on("change", function () {
                var classID = $("#classID").val();
                if (classID) {
                    update_section_dropdown(branch_id, classID);
                    update_subject_dropdown(branch_id, classID);
                }else{
                    $("sectionID").empty();
                    $("subject_name").empty();
                }
            });


        });


    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>