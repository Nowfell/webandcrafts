@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }} </h4>
        </div>
        <div class="col-lg-4 col-sm-8 col-md-8 col-xs-12">
            <a href="{{ route('admin.employee.create') }}" class="btn btn-outline btn-success btn-sm pull-right">Add Employee<i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
        <!-- /.page title -->
    </div>
@endsection

@push('page_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')

    <div class="row">


        <div class="col-md-12">
            <div class="white-box">

                @section('filter-section')
                <div class="row" id="ticket-filters">

                    <form action="" id="filter-form">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="email" name="employee_email" id="employeeEmail" data-style="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <select class="form-control select2" name="employee_name" id="employeeName" data-style="form-control">
                                    <option value="all">All</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Designation</label>
                                <select class="form-control select2" name="employee_designation" id="employeeDesignation" data-style="form-control">
                                    <option value="all">All</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->name }}">{{ $designation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="container-fluid">
                                    <div class="row filter-buttons">
                                        <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i>Apply</button>
                                        <button type="button" id="reset-filters" class="btn btn-inverse col-md-4 col-md-offset-1"><i class="fa fa-refresh"></i>Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endsection


                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="employees-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->

@endsection

@push('page_scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });
    var table;

    $(function() {
        loadTable();

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('employee-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted employee!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "{{ route('admin.employee.destroy',':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                                table._fnDraw();
                            }
                        }
                    });

                    location.reload();
                }
            });
        });

    });
    function loadTable(){

        var employee_email = $('#employeeEmail').val();
        var employee_name = $('#employeeName').val();
        var employee_designation = $('#employeeDesignation').val();

        table = $('#employees-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            destroy: true,
            stateSave: true,
            ajax: '{!! route('admin.employee.data') !!}?employee_email=' + employee_email + '&employee_name=' + employee_name + '&employee_designation=' + employee_designation,
            language: {
                "url": "<?php echo __("app.datatable") ?>"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'image', name: 'image', orderable: false, searchable: false  },
                { data: 'email', name: 'email' },
                { data: 'designation_name', name: 'designation_name' },
                { data: 'action', name: 'action', width: '15%', orderable: false, searchable: false }
            ]
        });
    }


    $('#apply-filters').click(function () {
        loadTable();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('#employeeEmail').val('');
        $('#employeeName').val('all');
        $('#employeeDesignation').val('all');
        $('#filter-form').find('select').select2();
        loadTable();
    })

</script>
@endpush
