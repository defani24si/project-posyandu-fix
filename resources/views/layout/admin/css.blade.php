<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>@yield('title', 'Admin Dashboard') - Posyandu</title>

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets-admin')}}/assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets-admin')}}/assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets-admin')}}/assets/img/favicon/favicon-16x16.png">

<!-- FontAwesome -->
<link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">

<!-- Sweet Alert -->
<link type="text/css" href="{{asset('assets-admin')}}/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Notyf -->
<link type="text/css" href="{{asset('assets-admin')}}/vendor/notyf/notyf.min.css" rel="stylesheet">

<!-- Volt CSS -->
<link type="text/css" href="{{asset('assets-admin')}}/css/volt.css" rel="stylesheet">

<!-- Custom Admin Styles -->
<style>
    body {
        background-color: #f8f9fa;
    }
    
    .navbar {
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
    }
    
    .card-header {
        background-color: #007bff;
        color: white;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1rem 1.5rem;
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>

@stack('styles')

