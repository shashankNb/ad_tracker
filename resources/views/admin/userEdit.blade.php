<x-admin-layout title="Edit User - {{ $user->name }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>Edit User</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">Manage Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Edit User</div>
            <form action="{{ route('users.edit', $user->id) }}" method="POST" class="form-horizontal">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="name" name="name" placeholder="Enter Name" value="{{ old('name') ?? $user->name }}" class="col-md-10 form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="username">Username</label>
                        <div class="col-sm-10">
                            <input type="text" id="username" name="username" placeholder="Enter Username" value="{{ old('username') ?? $user->username }}" class="col-md-10 form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">Email</label>
                        <div class="col-sm-10">
                            <input type="email" id="email" name="email" placeholder="Enter Email" value="{{ old('email') ?? $user->email }}" class="col-md-10 form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="password">Password</label>
                        <div class="col-sm-10">
                            <input type="password" id="password" name="password" placeholder="Enter Password" value="{{ old('password') }}" class="col-md-10 form-control "/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-flat pull-right" type="submit">Edit User</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
