<x-admin-layout title="Manage Users">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>Manage Users</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-users"></i> Users</a></li>
            <li class="active">Manage Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Manage Users</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Id</th>
                            <th scope="col" class="text-center">Name</th>
                            <th scope="col" class="text-center">Username</th>
                            <th scope="col" class="text-center">Email</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(auth()->user()->id == 1 || auth()->user()->id == $user->id)
                                <a class="btn btn-default btn-sm btn-flat"
                                   href="{{ route('users.edit', $user->id) }}"><i
                                        class="fa fa-pencil-square-o"></i> Edit</a>
                                <a class="btn btn-danger btn-sm btn-flat" data-toggle="confirmation" data-placement="bottom"
                                   href="{{ route('users.delete', $user->id) }}"><i
                                        class="fa fa-trash"></i> Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
