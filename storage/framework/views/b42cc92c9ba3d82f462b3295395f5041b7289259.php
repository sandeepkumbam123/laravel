<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            All Class
        </h1>

        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>

        <form class='col s3' method='get' action='<?php echo url("portal/class"); ?>/create'>
            <button class='btn btn-primary' type='submit'>Create New Class</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff'>
            <thead>
            <th>ID</th>
            <?php if(Session::get('role_name') == $const_role_name): ?>
                <th>Branch</th>
            <?php endif; ?>
            <th>Class</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php $__currentLoopData = $class_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($class_name->classID); ?></td>
                    <?php if(Session::get('role_name') == $const_role_name): ?>
                        <td><?php echo $class_name->branch_name; ?></td>
                    <?php endif; ?>
                    <td><?php echo $class_name->class_name; ?></td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/class/<?php echo $class_name->classID; ?>/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/class/<?php echo $class_name->classID; ?>/edit'><i class='material-icons'>Edit</i></a>
                        
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>


    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>