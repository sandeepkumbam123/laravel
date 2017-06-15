<?php $__env->startSection('content'); ?>

    <section class="content">
    <h1>
        Questions
    </h1>
    <form class = 'col s3' method = 'get' action = '<?php echo url("portal/question"); ?>/create'>
        <button class = 'btn btn-primary' type = 'submit'>Create New Question</button>
        <a class = 'btn btn-primary pull-right' href=<?php echo url("portal/upload-question/"); ?>>Upload Questions</a>
    </form>


    <br>
    <br>
    <table class = "table table-striped table-bordered table-hover" cellspacing="0" width="100%" style = 'background:#fff' id="data_table">
        <thead>
            <th>Subject</th>
            <th>Chapter</th>
            <th>Class</th>
            <th>Question</th>
            <th>Mark</th>
            <th>Critical</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
            <tr>
                <td><?php echo $question->subject; ?></td>
                <td><?php echo $question->chapter; ?></td>
                <td><?php echo $question->class_name; ?></td>

                <td><?php
                    if($question->is_image=='yes'){
                    ?><img src="<?php echo asset("public".$question->question); ?>" height="100" width="100">

                <?php }else{?>
                    <?php echo $question->question; ?>

                    <?php }?>

                </td>

                <td><?php echo $question->mark; ?></td>
                <td><?php echo $critical_level[$question->critical_level]; ?></td>

                <td style="width:200px">
                    <a data-toggle="modal" data-target="#myModal" class = 'delete btn btn-danger btn-xs' data-link = "/portal/question/<?php echo $question->questionID; ?>/deleteMsg" ><i class = 'material-icons'>Delete</i></a>
                    <a href = '#' class = 'viewEdit btn btn-primary btn-xs' data-link = '/portal/question/<?php echo $question->questionID; ?>/edit'><i class = 'material-icons'>Edit</i></a>
                    <a href = '#' class = 'viewShow btn btn-warning btn-xs' data-link = '/portal/question/<?php echo $question->questionID; ?>'><i class = 'material-icons'>Info</i></a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
        </tbody>
    </table>


</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>