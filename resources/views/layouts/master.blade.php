<!doctype html>
<html>
    @include('partials.head')

    <body>
        @yield('content')

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
