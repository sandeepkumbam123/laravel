<?php $__env->startSection('content'); ?>

    <section class="content">
    <h1>
        Create syllabus
    </h1>
    <form method = 'get' action = '<?php echo url("portal/syllabus"); ?>'>
        <button class = 'btn btn-danger'>All Syllabus</button>
    </form>
    <br>
    <form method = 'POST' action = '<?php echo url("portal/syllabus"); ?>'>
        <input type = 'hidden' name = '_token' value = '<?php echo e(Session::token()); ?>'>
        <div class="form-group has-feedback <?php echo e($errors->has('syllabus') ? ' has-error' : ''); ?>">
            <label for="syllabus">Syllabus</label>
            <input id="syllabus" name="syllabus" type="syllabus" class="form-control" value="<?php echo e(old('syllabus')); ?>" autocomplete="off">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <?php if($errors->has('syllabus')): ?>
                <span class="help-block">
                        <strong><?php echo e($errors->first('syllabus')); ?></strong>
                    </span>
            <?php endif; ?>
        </div>

        <button class = 'btn btn-primary' type ='submit'>Create</button>
    </form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>