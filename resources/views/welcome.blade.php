<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h2 style="text-align: center;">URL Shortener</h2>

                    {{-- Code to show all errors that occured during the shortening process. --}}
                    @foreach($errors->all() as $error)
                        <p class="alert alert-danger"> {{ $error }} </p>
                    @endforeach

                    {{-- Code to get any message that the shortening proccess outputs, both shortened urls and runtime messages. --}}
                    @if(session('message'))
                        <div class="alert alert-success">
                            {!! session('message') !!}
                        </div>
                    @endif

                    {{-- Form to collect long url from the user. --}}
                    <form action="/make" method="post">

                        @csrf

                        <div class="form-group">
                            <input type="url" name="url" class="form-control" placeholder="Insert Url here" value="{{ old('url') }}" required> <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
