<x-admin-layout title="Manage Link Groups">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Link Groups
            <small>Manage Link Groups</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-links"></i> Link Groups</a></li>
            <li class="active">Manage Link Groups</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Manage Link Groups</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Id</th>
                            <th scope="col" class="text-center">Link Group</th>
                            <th scope="col" class="text-center">Username</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($linkGroups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->group_name }}</td>
                            <td>{{ $group->user->username }}</td>
                            <td>
                                <a class="btn btn-default btn-sm btn-flat"
                                   href="{{ route('link_groups.edit', $group->id) }}"><i
                                        class="fa fa-pencil-square-o"></i> Edit</a>
                                <a class="btn btn-danger btn-sm btn-flat" data-toggle="confirmation" data-placement="bottom"
                                   href="{{ route('link_groups.delete', $group->id) }}"><i
                                        class="fa fa-trash"></i> Delete</a>
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
