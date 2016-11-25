<html>
    <head>
        <title>Orderssysteem</title>
        <link rel="shortcut icon" href="{{ URL::asset('img/') }}"/>
        <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
        <link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ URL::asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ URL::asset('css/orderssysteem.css') }}" rel="stylesheet" type="text/css" >        
    </head>
    <body>
        @include('layouts.navigation')
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('message'))
            <div class="container">
                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
        <div class="container-fluid">
            @yield('header')

            @yield('content')
        </div>
    </body>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('locales/bootstrap-datetimepicker.nl.min.js') }}" charset="UTF-8"></script>
        <script src="{{ URL::asset('js/orderssysteem.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.js') }}"></script>
        
</html> 
