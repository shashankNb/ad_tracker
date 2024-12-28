<x-admin-layout title="Manage Tracking Links">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tracking Links
            <small>Manage Tracking Links</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-links"></i> Tracking Links</a></li>
            <li class="active">Manage Tracking Links</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Manage Tracking Links</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Id</th>
                            <th scope="col" class="text-center">Tracking Link</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trackingLinks as $link)
                        <tr>
                            <td>{{ $link->id }}</td>
                            <td>{{ $link->link }}</td>
                            <td>
                                <a class="btn btn-default btn-sm btn-flat"
                                   href="{{ route('trackingLinks.edit', $link->id) }}"><i
                                        class="fa fa-pencil-square-o"></i> Edit</a>
                                <a class="btn btn-danger btn-sm btn-flat" data-toggle="confirmation" data-placement="bottom"
                                   href="{{ route('trackingLinks.delete', $link->id) }}"><i
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
