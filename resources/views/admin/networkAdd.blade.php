<x-admin-layout title="Add New Network">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Network
            <small>Add Network</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-globe"></i> Networks</a></li>
            <li class="active">Manage Networks</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Add Network</div>
            <form action="{{ route('networks.add') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="network_name">Network</label>
                        <div class="col-sm-10">
                            <input type="text" id="network_name" name="network_name" value="{{ old('network_name') }}" placeholder="Enter Network Name" class="col-md-10 form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="network_code">Network Code</label>
                        <div class="col-sm-10">
                            <input type="text" id="network_code" name="network_code" value="{{ old('network_code') }}" placeholder="Enter Network Code" class="col-md-10 form-control "/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-flat pull-right" type="submit">Add Network</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
