@extends('layouts.app', [
    'title' => 'Meters',
    'breadcrumb' => [
        'title' => 'Meters',
        'links' => [
            [
                'title' => 'Home',
                'url' => route("home")
            ],
            [
                'title' => 'Meters',
                'active' => true
            ]
        ]
    ]
])

@push('style')
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Meters</h3>
                    <div class="card-tools">
                        <a href="{{ route("meters.create") }}" class="btn btn-secondary">
                            Add Meter
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Industry</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Location</th>
                                <th>Last Reading At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="/assets/plugins/datatables/jquery.dataTables.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            datatable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route("meters.index") }}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'industry.name', name: 'industry', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'code', name: 'code' },
                    { data: 'location', name: 'location' },
                    { data: 'last_reading_at', name: 'last_reading_at', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false, className: "text-center" },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center" },
                ]
            });

            $(document).on('click', '.delete', function() {
                var url = $(this).data("url");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: $(this).data('id')
                            },
                            success: function(data) {
                                datatable.draw();
                                show_notify(data.message, 'success');
                            },
                            error: function(data) {
                                datatable.draw();
                                show_notify(data.responseJSON.message, 'error');
                            }
                        });
                    }
                });
            });

            $(document).on("click", ".copy-key, .copy-data", function(){
                var key = $(this).attr("data-key")
                var $tempInput = $("<input>");
                $("body").append($tempInput);
                $tempInput.val(key).select();
                var successful = document.execCommand('copy');
                $tempInput.remove();
                show_notify("Copied", 'success');
            })
        });
    </script>
@endpush