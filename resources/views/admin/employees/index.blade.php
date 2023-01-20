@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 table-responsive">
        <br />
        <h3 align="left">Employees</h3>
        <br />
        <div align="right">
            <a href="{{ route('admin.employees.create') }}" class="btn btn-success"> <i class="bi bi-plus-square"></i> Add</a>
        </div>
        <br />
            <table class="table table-striped table-bordered employee_datatable" id="employee_table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Date of employment</th>
                        <th>Phone number</th>
                        <th>Email</th>
                        <th>Salary</th>
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
        var table = $('.employee_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.employees.index') }}",
            columns: [
                {data: 'image_path', name: 'image_path',  orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'recruitment_date', name: 'recruitment_date'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'email', name: 'email'},
                {data: 'payment', name: 'payment',  render: $.fn.dataTable.render.number( ',', '.', 3, '$')},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

    var employee_id;

            $(document).on('click', '.delete', function(){
                employee_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function(){
                $.ajax({
                    type: 'DELETE',
                    url:"/admin/employees/destroy/"+employee_id,
                    beforeSend:function(){
                        $('#ok_button').text('Deleting...');
                    },
                    success:function(data)
                    {
                        setTimeout(function(){
                        $('#confirmModal').modal('hide');
                        $('#employee_table').DataTable().ajax.reload();
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

