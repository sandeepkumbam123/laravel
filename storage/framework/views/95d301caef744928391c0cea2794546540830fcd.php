<?php use App\Http\Controllers\ExamController; ?>
<?php $__env->startSection('content'); ?>

    <section class="content">
        <h1>
            All Exams
        </h1>

        <?php if(Session::has('status')): ?>
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                <?php echo e(Session::get('status')); ?>


            </div>
            <br>
        <?php endif; ?>
        <form class='col s3' method='get' action='<?php echo url("portal/search-questions"); ?>'>
            <button class='btn btn-primary' type='submit'>Create New exam</button>
            <a class='btn btn-primary '  href="<?php echo url("portal/exam/generate-exam"); ?>" style="margin-left: 20%">Automated Exam</a>
            <a class='btn btn-primary pull-right' href="<?php echo url("portal/exam/upload"); ?>">Upload Exam</a>

        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover" style='background:#fff' id="data_table">
            <thead>
            <?php if(Session::get('role_name') == $const_role_name): ?>
                <th>Branch</th>
            <?php endif; ?>
            <th>Title</th>
            <th>Class</th>
            <th>Subjects</th>
            <th>Exam ID</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if(Session::get('role_name') == $const_role_name): ?>
                        <td><?php echo ucfirst($exam->branch_name); ?></td>
                    <?php endif; ?>
                    <td><?php echo ucfirst($exam->title); ?></td>
                    <td><?php echo ucfirst($exam->class_name); ?></td>


                    <td><?php
                        $subs = explode(",", $exam->subjectIDS);
                        foreach ($subs as $subId) {
                            $sub_data = ExamController::objArraySearch($subjects, "subjectID", $subId);
                            echo $sub_data->subject . "<br>";
                        }

                        ?></td>
                    <td><?php echo $exam->exam_manualID; ?></td>
                    <td><?php echo $exam->is_active=="true" ? "Active": "Inactive"; ?></td>
                    <td><?php echo date("d-m-Y",strtotime($exam->exam_date)); ?></td>
                    <td>
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/exam/<?php echo $exam->examID; ?>/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/editexam-stepone/<?php echo $exam->examID; ?>/edit'><i class='material-icons'>Edit</i></a>
                        
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>