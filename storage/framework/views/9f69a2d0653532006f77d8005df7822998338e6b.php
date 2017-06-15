<?php $__env->startSection('content'); ?>

    <section class="content">
    <h1>
        Syllabus
    </h1>
    <form class = 'col s3' method = 'get' action = '<?php echo url("portal/syllabus"); ?>/create'>
        <button class = 'btn btn-primary' type = 'submit'>Create New syllabus</button>
    </form>
    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" style = 'background:#fff'>
        <thead>
            <th>Syllabus</th>

            <th>Actions</th>
        </thead>
        <tbody>
            <?php $__currentLoopData = $syllabuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $syllabus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <tr>
                <td><?php echo $syllabus->syllabus; ?></td>

                <td>
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/portal/syllabus/<?php echo $syllabus->syllabuseID; ?>/deleteMsg" ><i class = 'material-icons'>Delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/portal/syllabus/<?php echo $syllabus->syllabuseID; ?>/edit'><i class = 'material-icons'>Edit</i></a>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>
    </table>
    <?php echo $syllabuses->render(); ?>


</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>