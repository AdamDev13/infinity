<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Infinity Communications</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link
        rel="preload"
        href="{{mix("/font/Inter-roman.var.woff2")}}"
        as="font"
        type="font/woff2"
        crossorigin="anonymous"
    />

{{--    <link rel="stylesheet" href="{{mix('font/inter.css')}}" />--}}
    <link rel="stylesheet" href="{{mix('css/app.css')}}" />
</head>
<body>
@if (Auth::check())
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedin' => true,
            'user' => Auth::user()
        ])!!}
    </script>
@else
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedin' => false
        ])!!}
    </script>
@endif
<div id="app"></div>
<script src="{{ mix('js/app.js') }}"></script>

<script>
    function openNav() {
        var element = document.getElementById("user-menu");
        element.classList.toggle("hidden");
    }
    function dropdownNav() {
        var element = document.getElementById("nav-child");
        element.classList.toggle("hidden");
    }
</script>



</body>
</html>
