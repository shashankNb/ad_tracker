<x-admin-layout title="Add New Link">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Link
            <small>Add Link</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-globe"></i> Links</a></li>
            <li class="active">Manage Links</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Add New Link</div>
            <form action="{{ route('links.add') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="box-body">
                    @include('admin.errors')
                    @include('admin.session')
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="group_name">Networks</label>
                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
                            <select name="network_id" id="network_id" class="form-control">
                                @foreach($networks as $network)
                                <option value="{{ $network->id }}">{{ $network->network_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="group_name">Link Group</label>
                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
                            <select name="group_id" id="group_id" class="form-control">
                                @foreach($linkGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="link_name">Link</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   id="link_name" name="link_name" value="{{ old('link_name') }}"
                                   placeholder="Enter Link Name" class="col-md-10 form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tracking_link">Tracking Link</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <select name="tracking_link_id" class="form-control" id="tracking_link_id">
                                    @foreach($trackingLinks as $trackingLink)
                                    <option value="{{ $trackingLink->id }}"> {{ $trackingLink->link }} </option>
                                    @endforeach
                                </select>
                                <span class="input-group-addon">/</span>
                                <input type="text" id="tracking_slug" name="tracking_slug" value="{{ old('tracking_slug') }}" placeholder="Tracking slug" class="form-control "/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="primary_url">Primary URL</label>
                        <div class="col-sm-10">
                            <input type="text" id="primary_url" name="primary_url" value="{{ old('primary_url') }}" placeholder="Enter Primary URL" class="form-control "/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="is_action">Action Link?</label>
                        <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
                            <select name="is_action" id="is_action" class="form-control">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary btn-flat pull-right" type="submit">Add Link</button>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>
