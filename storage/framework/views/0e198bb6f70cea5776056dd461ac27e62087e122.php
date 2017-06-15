<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            Create Teacher
        </h1>


        <form method='get' action='<?php echo url("portal/teacher"); ?>'>
            <button class='btn btn-danger'>All Teachers</button>
        </form>
        <br>
        <form method='POST' action='<?php echo url("portal/teacher"); ?>' enctype="multipart/form-data">
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
                <input type="hidden" name="branches_branchID" value="<?php echo e(Session::get('branch_id')); ?>">
                <?php } ?>

            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('user_name') ? ' has-error' : ''); ?>">
                <label for="user_name">User Name</label>
                <input id="user_name" name="user_name" type="text" class="form-control" value="<?php echo e(old('user_name')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('user_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('user_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo e(old('first_name')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('first_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('first_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo e(old('last_name')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('last_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('email_id') ? ' has-error' : ''); ?>">
                <label for="email">E-mail</label>
                <input id="email" name="email_id" type="email" class="form-control" value="<?php echo e(old('email_id')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('email_id')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email_id')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                <label for="password">Password</label>
                <input id="password" name="password" type="text" class="form-control" value="<?php echo e(old('password')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('mobile') ? ' has-error' : ''); ?>">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo e(old('mobile')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('mobile')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('mobile')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('dob') ? ' has-error' : ''); ?>">
                <label for="dob">DOB</label>
                <input id="dob" name="dob" type="date" class="form-control" value="<?php echo e(old('dob')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('dob')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('dob')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('profile_pic') ? ' has-error' : ''); ?>">
                <label for="profile_pic">Profile Picture</label>
                <input id="profile_pic" name="profile_pic" type="file" class="form-control" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('profile_pic')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('profile_pic')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <button class='btn btn-primary' type='submit'>Create</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', Session::get('branch_id')); ?>">
            <input type="hidden" id="old_class" value="<?php echo old('class_names_classID'); ?>">
            <input type="hidden" id="old_section" value="<?php echo old('sectionID'); ?>">


        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>