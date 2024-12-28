<x-admin-layout title="Manage Networks">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Network
            <small>Manage Networks</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-globe"></i> Networks</a></li>
            <li class="active">Manage Networks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Manage Networks</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Id</th>
                            <th scope="col" class="text-center">Network Name</th>
                            <th scope="col" class="text-center">Network Code</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($networks as $network)
                        <tr>
                            <td>{{ $network->id }}</td>
                            <td>{{ $network->network_name }}</td>
                            <td>{{ $network->network_code }}</td>
                            <td>
                                <a class="btn btn-default btn-sm btn-flat"
                                   href="{{ route('networks.edit', $network->id) }}"><i
                                        class="fa fa-pencil-square-o"></i> Edit</a>
                                <a class="btn btn-danger btn-sm btn-flat" data-toggle="confirmation" data-placement="bottom"
                                   href="{{ route('networks.delete', $network->id) }}"><i
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
