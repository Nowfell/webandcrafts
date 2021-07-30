<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/themify-icons/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_1.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_2.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link href="{{ asset('plugins/froiden-helper/helper.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    {{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav> --}}

    <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')

    <!-- Page Content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <div id="page-wrapper" class="row">

                @if($filter_section)
                    <div class="col-md-3 filter-section">
                        <h5><i class="fa fa-sliders"></i>Filter Result</h5>
                        @yield('filter-section')
                    </div>
                @endif



                <div class="@if($filter_section) col-md-9 @else col-md-12 @endif data-section">

                    @yield('page-title')

                            <!-- .row -->
                    @yield('content')

                </div>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /.container-fluid -->
    </div>

{{-- <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div> --}}

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2020-2021 <a href="https://adminlte.io">WebAndCrafts Test</a>.</strong> All rights
        reserved.
    </footer>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
<script src="{{ asset('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/froiden-helper/helper.js') }}"></script>
<script src="{{ asset('plugins/toast-master/js/jquery.toast.js') }}"></script>


@stack('page_scripts')
</body>
</html>
