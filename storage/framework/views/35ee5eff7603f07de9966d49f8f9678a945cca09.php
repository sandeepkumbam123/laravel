<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div style="clear: both;margin-top: 2%"></div>
        <div class="row">

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo e($teachers); ?></h3>
                        <p>Teachers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-woman"></i>
                    </div>
                    <a href="<?php echo e(url('portal/teacher')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo e($users); ?></h3>
                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="<?php echo e(url('portal/user')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo e($branches); ?></h3>
                        <p>Branches</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-arrow-expand"></i>
                    </div>
                    <a href="<?php echo e(url('portal/branch')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo e($classes); ?></h3>
                        <p>Classes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-grid"></i>
                    </div>
                    <a href="<?php echo e(url('portal/class')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo e($sections); ?></h3>
                        <p>Sections</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-puzzle-piece"></i>
                    </div>
                    <a href="<?php echo e(url('portal/section')); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>


        </div>
        <div style="clear: both;margin-top: 5%"></div>
        <div class="row">
            <div class="col-lg-10 col-xs-12">
                <table class="table table-condensed ">

                    <tr class="danger">
                        <th>Organisation</th>
                        <td><?php echo e($orgs[0]->name); ?></td>
                        <th>Email</th>
                        <td><?php echo e($orgs[0]->email); ?></td>
                    </tr>

                    <tr class="warning">

                        <th>Phone</th>
                        <td><?php echo e($orgs[0]->contact); ?></td>
                        <th>City</th>
                        <td><?php echo e($orgs[0]->city); ?></td>
                    </tr>


                    <tr class="info">
                        <th>Address</th>
                        <td colspan="3"><address><?php echo e($orgs[0]->address); ?></address></td>
                    </tr>
                    <tr class="success">
                        <th>Subscribed On</th>
                        <td><?php echo e($orgs[0]->register_date); ?></td>
                        <th>Subscription Expired On</th>
                        <td><?php echo e($orgs[0]->expired_on); ?></td>
                    </tr>



                    <tr>
                    </tr>

                </table>
            </div>
        </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>