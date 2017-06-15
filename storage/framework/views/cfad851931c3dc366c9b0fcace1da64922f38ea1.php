<?php $__env->startSection('content'); ?>
    <section class="content">
        <h1>
            Upload Students
        </h1>
        <form method='get' action='<?php echo url("portal/user"); ?>'>
            <button class='btn btn-danger'>Show All Students</button>
        </form>
        <br>

        <?php if(isset($total) && $total>0){?>

        <div class="alert alert-success" role="alert" id="succ_div">
            Totally <strong><?php echo $total; ?> Students</strong> has been upload to the DB successfully.
        </div>
        <br>
        <?php } ?>


        <?php if(isset($failed_rows) && count($failed_rows)>0){?>

        <div class="alert alert-danger" role="alert" id="fail_div" style="max-width:200px">
            <strong>Oh snap!</strong>The following row(s) has false data so didn't upload to the DB.
            <br><strong><?php echo implode(",",$failed_rows);?></strong>
        </div>
        <br>
        <?php } ?>



        <form method='POST' action='<?php echo url("portal/user/upload-user"); ?>' enctype="multipart/form-data">
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>


            <div class="form-group has-feedback <?php echo e($errors->has('branches_branchID') ? ' has-error' : ''); ?>">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    <?php $__currentLoopData = $all_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->branchID); ?>"
                                <?php if(old('branches_branchID') == $branch->branchID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($branch->branch_name)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('branches_branchID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('branches_branchID')); ?></strong>
                    </span>

                <?php endif; ?>

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="<?php echo e($user->branchID); ?>">
                <?php } ?>

            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('class_names_classID') ? ' has-error' : ''); ?>">
                <label for="class_name">Class</label>

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


            <div class="form-group has-feedback <?php echo e($errors->has('sectionID') ? ' has-error' : ''); ?>">
                <label for="class_name">Section</label>

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

            <div class="form-group has-feedback <?php echo e($errors->has('csvFile') ? ' has-error' : ''); ?>">
                <label for="csvFile">csvFile</label>
                <input id="csvFile" name="csvFile" type="file" class="form-control">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('csvFile')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('csvFile')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <button class='btn btn-primary' type='submit'>Upload</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID'); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_section" value="<?php echo old('sectionID'); ?>">

        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>