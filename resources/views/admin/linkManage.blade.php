<x-admin-layout title="Manage Links">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Links
            <small>Manage Links</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-links"></i> Links</a></li>
            <li class="active">Manage Links</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Manage Links</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <table id="dataTable" class="table table-bordered table-hover dataTable">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">Id</th>
                        <th scope="col" class="text-center">Link Group</th>
                        <th scope="col" class="text-center">Network</th>
                        <th scope="col" class="text-center">Link (Friendly Name)</th>
                        <th scope="col" class="text-center">Tracking Link</th>
                        <th scope="col" class="text-center">Tracking Slug</th>
                        <th scope="col" class="text-center">Primary URL</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($links as $link)
                    <tr>
                        <td>{{ $link->id }}</td>
                        <td>{{ $link->linkGroup->group_name }}</td>
                        <td>{{ $link->network->network_name }}</td>
                        <td>{{ $link->link_name }}</td>
                        <td>
                            <a href="{{ $link->trackingLinks->link }}/{{ $link->tracking_slug }}" target="_blank">{{ $link->trackingLinks->link }}</a>
                        </td>
                        <td>
                            <a href="{{ $link->trackingLinks->link }}/{{ $link->tracking_slug }}" target="_blank">{{ $link->tracking_slug }}</a>
                        </td>
                        <td>{{ $link->primary_url }}</td>
                        <td>
                            <a class="btn btn-default btn-sm btn-flat"
                               href="{{ route('links.edit', $link->id) }}"><i
                                    class="fa fa-pencil-square-o"></i> Edit</a>
                            <a class="btn btn-danger btn-sm btn-flat" data-toggle="confirmation" data-placement="bottom"
                               href="{{ route('links.delete', $link->id) }}"><i
                                    class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
