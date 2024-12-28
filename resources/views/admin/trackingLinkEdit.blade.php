<x-admin-layout title="Edit Tracking Link - {{ $trackingLink->link }}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tracking Links
            <small>Edit Tracking Links</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-link"></i> Tracking Links</a></li>
            <li class="active">Edit Tracking Links</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Edit Link Group</div>
            <form action="{{ route('trackingLinks.edit', $trackingLink->id) }}" class="form-horizontal" method="POST">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="TrackingLinkName">Tracking Link</label>
                        <div class="col-sm-10">
                            <input type="text" id="trackingLinkName" value="{{ old('link') ?? $trackingLink->link }}" name="link" placeholder="Enter Tracking Links" class="col-md-10 form-control "/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-sm btn-flat pull-right" type="submit">Edit Tracking Links</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
