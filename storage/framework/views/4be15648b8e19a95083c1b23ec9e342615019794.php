<?php $__env->startSection('content'); ?>
<section class="content">
    <h1>
        Show user
    </h1>
    <br>
    <form method = 'get' action = '<?php echo url("portal/user"); ?>'>
        <button class = 'btn btn-primary'>user Index</button>
    </form>
    <br>
    <table class = 'table table-bordered'>
        <thead>
            <th>Key</th>
            <th>Value</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <b><i>branchID : </i></b>
                </td>
                <td><?php echo $user->branchID; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>roles_roleID : </i></b>
                </td>
                <td><?php echo $user->roles_roleID; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>reg_number : </i></b>
                </td>
                <td><?php echo $user->reg_number; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>user_name : </i></b>
                </td>
                <td><?php echo $user->user_name; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>first_name : </i></b>
                </td>
                <td><?php echo $user->first_name; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>last_name : </i></b>
                </td>
                <td><?php echo $user->last_name; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>email : </i></b>
                </td>
                <td><?php echo $user->email; ?></td>
            </tr>

            <tr>
                <td>
                    <b><i>mobile : </i></b>
                </td>
                <td><?php echo $user->mobile; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>dob : </i></b>
                </td>
                <td><?php echo $user->dob; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>age : </i></b>
                </td>
                <td><?php echo $user->age; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>profile_pic : </i></b>
                </td>
                <td><?php echo $user->profile_pic; ?></td>
            </tr>
            <tr>
                <td>
                    <b><i>classID : </i></b>
                </td>
                <td><?php echo $user->classID; ?></td>
            </tr>
        </tbody>
    </table>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.portalLayout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>