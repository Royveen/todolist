<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel='stylesheet' href="{{ asset('css/app.css') }}"
        
    </head>
    <body>
       <div id="app">
       <div class="navbar">
       <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">ToDoist</a>
        </nav>   
       </div>
        <div class="container">

            <div class="row">
                <div class="col-md-4 options">
                    <task-options></task-options>
                </div>
                <div class="col-md-6">
                    <task-list></task-list>
                </div>
            </div>
        </div>
       </div>

       <script src="{{ asset('js/app.js')}}"></script>
    </body>
</html>
