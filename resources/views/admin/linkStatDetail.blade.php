@include('admin.errors')
@include('admin.session')
<div class="table-responsive">
    <table id="statsTable" class="table table-bordered table-hover dataTable table-responsive">
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
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($link->linkStats as $key => $stats)
        <tr id="tr-stat-{{$stats->id}}">
            <td>{{ $key + 1 }}</td>
            <td>{{ $stats->click_id }}</td>
            <td>{{ $stats->ip_address }}</td>
            <td>{{ $stats->user_agent }}</td>
            <td>{{ $stats->action }}</td>
            <td>{{ $stats->subId_1 }}</td>
            <td>{{ $stats->subId_2 }}</td>
            <td>{{ $stats->subId_3 }}</td>
            <td>{{ $stats->subId_4 }}</td>
            <td>{{ $stats->subId_5 }}</td>
            <td>{{ Carbon\Carbon::parse($stats->created_at)->toDayDateTimeString() }}</td>
            <td>{{ Carbon\Carbon::parse($stats->updated_at)->toDayDateTimeString() }}</td>
            <td>
                <a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-flat btn-danger" onclick="clearStatDetail({{ $stats->id }})"><i class="fa fa-trash"></i> Clear</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
