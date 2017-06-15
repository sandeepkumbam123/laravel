<?php $__env->startSection('content'); ?>
    <section class="content" style="overflow: auto;">
        <h1>
            <?php echo strtoupper($roles[0]->user_name); ?>'s Roles
        </h1>
        <br>
        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>
        <form class='col s3' method='get' action='<?php echo url("portal/teacher"); ?>'>
            <button class='btn btn-primary' type='submit'>Show All Teachers</button>
            <a href='<?php echo url("portal/teacher/$id"); ?>/create' class="btn btn-primary pull-right">Add Role</a>
        </form>


        <br>
        <br>
        <table class="table  table-bordered " style='background:#fff;' id="data_table">
            <thead>

            <th>Class</th>
            <th>Section</th>
            <th>Subject</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>

                    <td><?php echo ucfirst($role->class_name); ?></td>
                    <td><?php echo ucfirst($role->section_name); ?></td>
                    <td><?php echo ucfirst($role->subject); ?></td>

                    <td style="width: 200px">
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/role/<?php echo $role->id; ?>/deleteRoleMsg/<?php echo $role->userID; ?>"><i class='material-icons'>Delete</i></a>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>