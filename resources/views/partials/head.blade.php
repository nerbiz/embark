<head>
    <title>{{ config('app.name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans"> --}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
