<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            All Branches
        </h1>
        <form class='col s3' method='get' action='<?php echo url("portal/branch"); ?>/create'>
            <button class='btn btn-primary' type='submit'>Create New branch</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff'>
            <thead>
            <th>ID</th>
            <th>Branch name</th>
            <th>Syllabus</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $branch->branchID; ?></td>
                    <td><?php echo $branch->branch_name; ?></td>
                    <td><?php echo $branch->syllabus; ?></td>
                    <td><?php echo $branch->email; ?></td>
                    <td><?php echo $branch->contact; ?></td>
                    <td style="width: 180px;"><?php echo $branch->address; ?></td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/branch/<?php echo $branch->branchID; ?>/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/branch/<?php echo $branch->branchID; ?>/edit'><i class='material-icons'>Edit</i></a>
                        <a href='#' class='viewShow btn btn-warning btn-xs' data-link='/portal/branch/<?php echo $branch->branchID; ?>'><i class='material-icons'>Info</i></a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>


    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>