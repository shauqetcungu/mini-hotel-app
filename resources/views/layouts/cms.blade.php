<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hotel mini app') }}</title>
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="app"></div>
<script>
    window.base_url = '{{ url('/') }}';
</script>
<script src="{{ asset('AdminLTE-3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}?v={{date('YmdHis')}}"></script>
</body>
</html>
