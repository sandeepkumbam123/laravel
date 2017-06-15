<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            Create branch
        </h1>
        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>

        <form method='get' action='<?php echo url("portal/branch"); ?>'>
            <button class='btn btn-danger'>Show Branches</button>
        </form>
        <br>
        <form method='POST' action='<?php echo url("portal/branch"); ?>'>
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>
            <div class="form-group has-feedback <?php echo e($errors->has('syllabuses_syllabuseID') ? ' has-error' : ''); ?>">

                <select id="syllabuses_syllabuseID" name="syllabuses_syllabuseID" class="form-control">
                    <option value="">Select A Syllabus</option>
                    <?php $__currentLoopData = $syllabus_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $syllabus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($syllabus->syllabuseID); ?>"
                                <?php if(old('syllabuses_syllabuseID') == $syllabus->syllabuseID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($syllabus->syllabus)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('syllabuses_syllabuseID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('syllabuses_syllabuseID')); ?></strong>
                    </span>
                <?php endif; ?>

            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('branch_name') ? ' has-error' : ''); ?>">
                <label for="branch_name">Branch Name</label>
                <input id="branch_name" name="branch_name" type="text" class="form-control" value="<?php echo e(old('branch_name')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('branch_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('branch_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="<?php echo e(old('email')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('email')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('contact') ? ' has-error' : ''); ?>">
                <label for="contact">Contact</label>
                <input id="contact" name="contact" type="text" class="form-control" value="<?php echo e(old('contact')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('contact')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('contact')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <div class="form-group has-feedback <?php echo e($errors->has('address') ? ' has-error' : ''); ?>">
                <label for="question">Address</label>
                <textarea rows="7" name="address" id="address" class="form-control"><?php echo e(old('address')); ?></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                <?php if($errors->has('address')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('address')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>
            <button class='btn btn-primary' type='submit'>Create</button>
        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>