@extends('layouts.portalLayout')

@section('content')
    <section class="content" style="overflow: auto;">
        <h1>
            All Teachers
        </h1>

        @if(Session::has('status'))
            <div class="alert alert-warning col-md-offset-2 text-center status_message">
                {{ Session::get('status') }}

            </div>
            <br>
        @endif
        <form class='col s3' method='get' action='{!!url("portal/teacher")!!}/create'>
            <button class='btn btn-primary' type='submit'>Create New Teacher</button>
        </form>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover table-nonfluid" style='background:#fff;  width: 1120px !important;word-wrap: break-word;' id="data_table">
            <thead>
            <?php if((Session::get('role_name') == $const_role_name)){ ?>
            <th>Branch</th> <?php } ?>
            <th>Profile Pic</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>DOB</th>
            <th>Actions</th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <?php if((Session::get('role_name') == $const_role_name)){ ?>
                    <td>{!!$user->branch_name!!}</td>
                    <?php } ?>
                    <td><?php if($user->profile_pic){ ?><img src="{!!  asset("public".$user->profile_pic) !!}" height="100" width="100"><?php }else{ ?>
                        <img src="{!!  asset("public"."/images/no_image.jpg") !!}" height="100" width="100"><?php }?>
                    </td>
                    <td>{!!$user->first_name!!}</td>

                    <td>{!!$user->email_id!!}</td>
                    <td>{!!$user->mobile!!}</td>
                    <td>{!!$user->dob!!}</td>

                    <td style="width: 200px">
                        <a data-toggle="modal" data-target="#myModal" class='delete btn btn-danger btn-xs' data-link="/portal/teacher/{!!$user->userID!!}/deleteMsg"><i class='material-icons'>Delete</i></a>
                        <a href='#' class='viewEdit btn btn-primary btn-xs' data-link='/portal/teacher/{!!$user->userID!!}/edit'><i class='material-icons'>Edit</i></a>
                        <a href='{!! url("portal/teacher/$user->userID/roles") !!}' class='btn btn-warning btn-xs'>Manage Role</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </section>
@endsection