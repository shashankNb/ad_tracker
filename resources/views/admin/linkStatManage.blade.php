<x-admin-layout title="Link Statistics and Reporting">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Link Statistics
            <small>View Link Reports</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Link Statistics</a></li>
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
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">S.N</th>
                            <th scope="col" class="text-center">Link Name</th>
                            <th scope="col" class="text-center">Total Clicks</th>
                            <th scope="col" class="text-center">Unique Clicks</th>
                            <th scope="col" class="text-center">Action Clicks</th>
                            <th scope="col" class="text-center">Conversion</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stats as $index => $stat)
                        <tr id="stat-{{$stat->link_id}}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="viewLinkStats('{{$stat->link_id}}')">{{
                                    $stat->link_name }}</a>
                                <a href="{{ route('linkStats.reports', $stat->link_id) }}" target="_blank" class="label label-primary pull-right">Open in a new tab</a>
                            </td>
                            <td>{{ $stat->total_clicks }}</td>
                            <td>{{ $stat->unique_clicks }}</td>
                            <td>{{ $stat->action_clicks }}</td>
                            <td>{{ $stat->conversion }}</td>
                            <td><a class="btn btn-danger btn-sm btn-flat" onclick="clearStats({{ $stat->link_id }}, {{ $index + 1 }})"><i class="fa fa-refresh"></i>
                                    Reset</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- modal -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalTitle">Detail</h4>
                </div>
                <div class="modal-body text-center" id="statBody"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <x-slot name="scripts">
        <script>
            let viewLinkStats = (id) => {
                $("#modal-default").modal('show');
                const headers = {headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}};
                const request = {
                    type: 'POST',
                    url: '{{ route("linkStats.detail") }}',
                    data: {linkId: id},
                    success: (response) => {
                        $("#statBody").html(response);
                        reloadDataTable();
                    },
                    error: (err) => {
                        $("#modal-default").modal('hide');
                        alert('Unable to View Stats. Check console for Errors.');
                        console.log(err);
                    }
                }
                $.ajaxSetup(headers);
                $.ajax(request);
            }

            let clearStats = (linkId, index) => {
                const button = event.target;
                button.setAttribute('disabled', true);
                const url = '{{ url("link-stats/delete") }}/' + linkId;
                const request = {
                    type: 'GET',
                    url: url,
                    success: (response) => {
                        $("#stat-"+linkId).fadeOut(200).fadeIn(200);
                        const row = `
                            <td>${index}</td>
                            <td>
                                <a href="javascript:void(0)" onclick="viewLinkStats(${response.link_id})">${response.link_name}</a>
                                <a href="{{ url('link-stats/reports') }}/${response.link_id}" target="_blank" class="label label-primary pull-right">Open in a new tab</a>
                            </td>
                            <td>${response.total_clicks}</td>
                            <td>${response.unique_clicks}</td>
                            <td>${response.action_clicks}</td>
                            <td>${response.conversion}</td>
                            <td><a class="btn btn-danger btn-sm btn-flat" onclick="clearStats(${response.link_id}, ${index})"><i class="fa fa-refresh"></i>
                                    Reset</a></td>
                        `;
                        $("#stat-"+linkId).html(row);
                        button.removeAttribute('disabled');
                    },
                    error: (err) => {
                        console.log(err);
                        button.removeAttribute('disabled');
                    }
                }
                $.ajax(request);
            }

            let clearStatDetail = (statId) => {
                const button = event.target;
                button.setAttribute('disabled', true);
                const url = '{{ url("link-stats/delete-detail") }}/' + statId;
                const request = {
                    type: 'GET',
                    url: url,
                    success: () => {
                        $("#tr-stat-"+statId).fadeOut(200, function() {
                            $("#tr-stat-"+statId).remove();
                        });
                    },
                    error: (err) => {
                        console.log(err);
                        button.removeAttribute('disabled');
                    }
                }
                $.ajax(request);
            }

            let reloadDataTable = () => {
                $('#statsTable').DataTable({
                    'paging'      : true,
                    "pageLength"  : 10,
                    'lengthChange': false,
                    'searching'   : true,
                    'ordering'    : true,
                    'info'        : false,
                    'autoWidth'   : true,
                    'responsive'  : true
                });
            }

            $('#modal-default').on('hidden.bs.modal', function () {
                $("#statBody").html('Loading...');
            });
        </script>
    </x-slot>
</x-admin-layout>


