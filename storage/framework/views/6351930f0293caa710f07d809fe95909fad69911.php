<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            All Sections
        </h1>
        <form class='col s3' method='get' action='<?php echo url("portal/section"); ?>/create'>
            <button class='btn btn-primary' type='submit'>Create New section</button>
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
            <th>Section</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($section->sectionID); ?></td>
                    <?php if(Session::get('role_name') == $const_role_name): ?>
                        <td><?php echo $section->branch_name; ?></td>
                    <?php endif; ?>
                    <td><?php echo $section->class_name; ?></td>
                    <td><?php echo $section->section_name; ?></td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/section/<?php echo $section->sectionID; ?>/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/section/<?php echo $section->sectionID; ?>/edit'><i class='material-icons'>Edit</i></a>
                        
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>