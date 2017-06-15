<?php $__env->startSection('content'); ?>
    <section class="content">
        <h1>
            Edit Teacher
        </h1>
        <form method='get' action='<?php echo url("portal/teacher"); ?>'>
            <button class='btn btn-danger'>All Teachers</button>
        </form>
        <br>
        <form method='POST' action='<?php echo url("portal/teacher"); ?>/<?php echo $user->
        userID; ?>/update' enctype="multipart/form-data">
            <input type='hidden' name='_token' value='<?php echo e(Session::token()); ?>'>


            <div class="form-group has-feedback <?php echo e($errors->has('branches_branchID') ? ' has-error' : ''); ?>">
                <?php if((Session::get('role_name') == $const_role_name)){ ?>
                <select id="branches_branchID" name="branches_branchID" class="form-control">
                    <option value="">Select A Branch</option>
                    <?php $__currentLoopData = $all_branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->branchID); ?>"
                                <?php if(old('branches_branchID',$user->branchID) == $branch->branchID): ?> selected="selected" <?php endif; ?>><?php echo e(ucfirst($branch->branch_name)); ?></option>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('branches_branchID')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('branches_branchID')); ?></strong>
                    </span>

                <?php endif; ?>

                <?php }else{ ?>
                <input type="hidden" name="branches_branchID" value="<?php echo e($user->branchID); ?>">
                <?php } ?>

            </div>




            <div class="form-group has-feedback <?php echo e($errors->has('user_name') ? ' has-error' : ''); ?>">
                <label for="user_name">User Name</label>
                <input id="user_name" name="user_name" type="text" class="form-control" value="<?php echo e(old('user_name',$user->user_name)); ?>" autocomplete="off">
                <input type="hidden" name="old_user_name" value="<?php echo e($user->user_name); ?>">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('user_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('user_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" class="form-control" value="<?php echo e(old('first_name',$user->first_name)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('first_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('first_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" class="form-control" value="<?php echo e(old('last_name',$user->last_name)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('last_name')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>

            <div class="form-group has-feedback <?php echo e($errors->has('email_id') ? ' has-error' : ''); ?>">
                <label for="email">E-mail</label>
                <input id="email" name="email_id" type="email" class="form-control" value="<?php echo e(old('email_id',$user->email_id)); ?>" autocomplete="off">
                <input type="hidden" name="old_email_id" value="<?php echo e($user->email_id); ?>">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('email_id')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('email_id')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('new_password') ? ' has-error' : ''); ?>">
                <label for="password">NEW Password</label>
                <input id="password" name="new_password" type="text" class="form-control" value="<?php echo e(old('new_password')); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('new_password')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('new_password')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('mobile') ? ' has-error' : ''); ?>">
                <label for="mobile">Mobile</label>
                <input id="mobile" name="mobile" type="text" class="form-control" value="<?php echo e(old('mobile',$user->mobile)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('mobile')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('mobile')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group has-feedback <?php echo e($errors->has('dob') ? ' has-error' : ''); ?>">
                <label for="dob">DOB</label>
                <input id="dob" name="dob" type="date" class="form-control" value="<?php echo e(old('dob',$user->dob)); ?>" autocomplete="off">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <?php if($errors->has('dob')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('dob')); ?></strong>
                    </span>
                <?php endif; ?>
            </div>


            <div class="form-group <?php echo e($errors->has('new_image') ? ' has-error' : ''); ?>">
                <label for="image">Profile Pic</label>
                <br>
                <?php if(!$errors->has('new_image')): ?>

                    <div class="profile-pic">
                        <?php if($user->profile_pic != ''){?>

                        <img src="<?php echo e(asset('public'.$user->profile_pic)); ?>" height="200"
                             width="200">
                        <?php }else{?>
                        <img src="<?php echo asset("public"."/images/no_image.jpg"); ?>" height="100" width="100">
                        <?php
                        }
                            ?>
                        <div class="edit delete_image"><i class="fa fa-pencil fa-lg"></i></div>
                    </div>



                <?php endif; ?>
                <input type="file" name="new_image" class="form-control" id="new_image"
                       <?php if($errors->has('new_image')): ?>style="display: block;" <?php else: ?>  style="display:none;" <?php endif; ?>>

                <input type="hidden" id="old_image" name="old_image" value="<?php echo e($user->profile_pic); ?>">
                <input type="hidden" id="is_new_image" name="is_new_image" value="no">
            </div>


            <button class='btn btn-primary' type='submit'>Update</button>

            <input type="hidden" id="old_branch" value="<?php echo old('branches_branchID', $user->branchID); ?>">


        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_scripts'); ?>

    <script>

        $(".delete_image").click(function (e) {
            e.preventDefault();
            //old_image,is_new_image,current_image
            $(".profile-pic").remove();
            $("#is_new_image").val("yes");
            $("#new_image").show();
            return false;

        });
    </script>







<?php $__env->stopSection(); ?>

<!-- fghfghffghfgfg contact form starts here  -->
<input type="text" name="username"
       id="user_name" class="a aasas asas"

       style="" data-abcd="asdasdsa">

<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>