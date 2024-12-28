<x-admin-layout title="Link Statistics and Reporting">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Link Reports
            <small>View Link Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Link Reports</a></li>
            <li class="active">View Link Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">Link Reports</div>
            <div class="box-body">
                @include('admin.errors')
                @include('admin.session')
                <div class="row margin-bottom">
                    <div class="col-xs-10 col-sm-8 col-md-6 col-lg-4">
                        <label>Search By :</label>
                        <select class="form-control" name="category" id="searchCategory"
                                onchange="window.location.href='{{ route("linkStats.reports", ['id' => $linkId]) }}/' + this.value">
                        <option value=""> Search By ID </option>
                        <option value="CAMPAIGN" {{ $category == 'CAMPAIGN' ? 'selected' : ''}}>Search By Campaign</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    @switch($category)
                    @case('CAMPAIGN')
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Keyword</th>
                                <th>Query String</th>
                                <th>Total Clicks</th>
                                <th>Unique Clicks</th>
                                <th>Action Clicks</th>
                                <th>Sale</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stats as $index => $stat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $stat->keyword }}</td>
                                <td>{{ $stat->queryString }}</td>
                                <td>{{ $stat->searchCount }}</td>
                                <td>{{ $stat->uniqueClicks }}</td>
                                <td>{{ $stat->action }}</td>
                                <td>{{ $stat->sale }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @break
                    @default
                        <table id="dataTable" class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Click ID</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Action</th>
                                <th>SUB_ID 1</th>
                                <th>SUB_ID 2</th>
                                <th>SUB_ID 3</th>
                                <th>SUB_ID 4</th>
                                <th>SUB_ID 5</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stats as $index => $stat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $stat->click_id }}</td>
                                <td>{{ $stat->ip_address }}</td>
                                <td>{{ $stat->user_agent }}</td>
                                <td>{{ $stat->action }}</td>
                                <td>{{ $stat->subId_1 }}</td>
                                <td>{{ $stat->subId_2 }}</td>
                                <td>{{ $stat->subId_3 }}</td>
                                <td>{{ $stat->subId_4 }}</td>
                                <td>{{ $stat->subId_5 }}</td>
                                <td>{{ Carbon\Carbon::parse($stat->created_at)->toDayDateTimeString() }}</td>
                                <td>{{ Carbon\Carbon::parse($stat->updated_at)->toDayDateTimeString() }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</x-admin-layout>


