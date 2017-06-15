@extends('layouts.portalLayout')
@section('content')
<section class="content">
    <h1>
        Show user
    </h1>
    <br>
    <form method = 'get' action = '{!!url("portal/user")!!}'>
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
                <td>{!!$user->branchID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>roles_roleID : </i></b>
                </td>
                <td>{!!$user->roles_roleID!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>reg_number : </i></b>
                </td>
                <td>{!!$user->reg_number!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>user_name : </i></b>
                </td>
                <td>{!!$user->user_name!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>first_name : </i></b>
                </td>
                <td>{!!$user->first_name!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>last_name : </i></b>
                </td>
                <td>{!!$user->last_name!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>email : </i></b>
                </td>
                <td>{!!$user->email!!}</td>
            </tr>

            <tr>
                <td>
                    <b><i>mobile : </i></b>
                </td>
                <td>{!!$user->mobile!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>dob : </i></b>
                </td>
                <td>{!!$user->dob!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>age : </i></b>
                </td>
                <td>{!!$user->age!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>profile_pic : </i></b>
                </td>
                <td>{!!$user->profile_pic!!}</td>
            </tr>
            <tr>
                <td>
                    <b><i>classID : </i></b>
                </td>
                <td>{!!$user->classID!!}</td>
            </tr>
        </tbody>
    </table>
</section>
@endsection