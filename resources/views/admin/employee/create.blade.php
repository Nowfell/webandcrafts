@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ $pageTitle }}</h4>
        </div>
        <!-- /.page title -->
    </div>
@endsection

@push('page_css')
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            {{-- {!!   $smtpSetting->set_smtp_message !!} --}}

            <div class="panel panel-inverse">
                <div class="panel-heading">Add Employee</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                <form id="addEmployee" class="forms-sample" method="POST" action="{{ route('admin.employee.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                            <h3 class="box-title">Employee Details</h3>
                            <hr>
                            <div class="row">

                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <select name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror">
                                            <option value="">--</option>
                                            @foreach($designations as $designation)
                                                <option value="{{ $designation->id }}" @if(old('designation')==$designation->id) selected @endif>{{ $designation->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label>Photo</label>
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail form-control @error('image') is-invalid @enderror" style="width: 200px; height: 150px;">
                                                <img id="imgPreview" src="http://via.placeholder.com/200x150.png?text='Upload Photo'"
                                                     alt=""/>
                                            </div>

                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;"></div>
                                            <div>
                                            <span class="btn btn-info btn-file">
                                                <span class="fileinput-new"> Select Image </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" id="image" name="image" onchange="readURL(this);">
                                            </span>
                                            <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput"> Remove </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" id="save-form" class="btn btn-success"><i
                                        class="fa fa-check"></i> Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->
@endsection

@push('page_scripts')
    <script data-name="basic">
        (function () {

            $("#designation").select2({
                formatNoMatches: function () {
                    return "{{ __('messages.noRecordFound') }}";
                }
            });

        })()
    </script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgPreview')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

