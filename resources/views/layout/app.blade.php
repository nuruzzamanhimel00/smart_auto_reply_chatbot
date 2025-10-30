<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <title>{{ getPageMeta('title') }} | {{ systemSettings('site_title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ getStorageImage(config('settings.site_favicon'), false, 'favicon') }}">
    @vite('resources/js/app.js')
    @include('admin.layouts.partials.styles')
    <style>
        .avatar-xs {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }

        .avatar-sm {
            width: 48px;
            height: 48px;
            font-size: 1.2rem;
        }

        .card {
            border-radius: 12px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
        }

        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }

        .btn {
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .badge {
            font-weight: 500;
            font-size: 0.8rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.02);
        }

        h1 {
            font-size: 1.75rem;
            color: #2c3e50;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.25rem;
            }

            .btn-lg {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<body data-sidebar="light"
    class="{{ \Route::is('orders.create') || \Route::is('orders.edit') ? 'sidebar-enable vertical-collpsed' : '' }} ">

    <div>
        <!-- Begin page -->
        <div id="layout-wrapper">


            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-0">
                        <!-- Header Card -->
                        @include('layout.header')
                        @yield('content')
                    </div> <!-- end col -->
                </div>
            </div>

        </div>
        <!-- END layout-wrapper -->
    </div>

    <!-- JAVASCRIPT -->
    @include('admin.layouts.partials.scripts')

</body>

</html>
