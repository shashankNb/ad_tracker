<x-admin-layout title="Add Link Group">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Link Group
            <small>Add New Link Group</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-link"></i> Link Group</a></li>
            <li class="active">Add Link Group</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Add Link Group</div>
            <form action="{{ route('link_groups.add') }}" class="form-horizontal" method="POST">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="LinkGroupName">Link Group Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="linkGroupName" name="group_name" value="{{ old('group_name') }}" placeholder="Enter Link Group" class="col-md-10 form-control "/>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-sm btn-flat pull-right" type="submit">Add Link Group</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
