@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 table-responsive">
        <br />
        <h3 align="left">Positions</h3>
        <br />
        <div align="right">
            <a href="{{ route('admin.positions.create') }}" class="btn btn-success"> <i class="bi bi-plus-square"></i> Add</a>
        </div>
        <br />
            <table class="table table-striped table-bordered position_datatable" id="position_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Last updated</th>
                        <th width="180px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('layouts.warning')
</div>
@stop

@section('css')
@include('layouts.links')
@stop

@push('scripts')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function() {
        var table = $('.position_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.positions.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    var position_id;

            $(document).on('click', '.delete', function(){
                position_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    type: 'DELETE',
                    url:"/admin/positions/destroy/"+position_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#position_table').DataTable().ajax.reload();
                        alert('Data Deleted');
                        $('#ok_button').text('OK');
                        }, 2000);
                },
                error: function(xhr, status, error) {
                    setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#employee_datatable').DataTable().ajax.reload(null, false);
                        alert('Data Not Deleted');
                        }, 2000);
                },
                })
            });
    </script>
@endpush

@section('js')
@stack('scripts')
@stop

