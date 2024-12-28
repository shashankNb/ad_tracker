<x-admin-layout title="Add New Tracking Link">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tracking Links
            <small>Add New Tracking Link</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-link"></i> Tracking Links</a></li>
            <li class="active">Add New Tracking Links</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Add New Tracking Links</div>
            <form action="{{ route('trackingLinks.add') }}" class="form-horizontal" method="POST">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="TrackingLinkName">Tracking Link Name:</label>
                        <div class="col-sm-10">
                            <input type="text" id="trackingLinkName" value="{{ old('link') }}" name="link" placeholder="Enter Tracking link" class="col-md-10 form-control "/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-sm btn-flat pull-right" type="submit">Add New Tracking Link</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
