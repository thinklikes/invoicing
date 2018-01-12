@inject('page', 'App\Presenters\PagePresenter')
@inject('presenter', 'App\Presenters\StatusPresenter')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('system_configs.website_title') }}</title>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0-rc.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Custom Javascript files -->
    <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/AjaxCombobox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bindDatePicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/AjaxFetchDataByField.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/appendItem.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/NewCombox.js') }}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0-rc.2/jquery-ui.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/general.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_table.css') }}">
    <style>
        body {
            font-family: 'Lato';
		}

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    <script type="text/javascript">
        var supplier_json_url = '{{ url('supplier/json') }}';
        var stock_json_url = '{{ url('stock/json') }}';
        var company_json_url = '{{ url('company/json') }}';
        var billOfPurchase_json_url = '{{ url('billOfPurchase/json') }}';
        var returnOfPurchase_json_url = '{{ url('returnOfPurchase/json') }}';
        var payment_json_url = '{{ url('payment/json') }}';
        var billOfSale_json_url = '{{ url('billOfSale/json') }}';
        var returnOfSale_json_url = '{{ url('returnOfSale/json') }}';
        var receipt_json_url = '{{ url('receipt/json') }}';
        $(function () {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
        });
    </script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">{{ config('system_configs.website_title') }}</a>
                </div>
@if (Auth::guest())
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{{ url('/login') }}">使用者登入</a></li>
                </ul>
@else
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ $page->getParentPageUrl() }}">回上一層</a></li>
                    {!! $page->getMenu() !!}
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ url('/system_config/updateLogs') }}">更新紀錄</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
@endif
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            {{--
            @section('sidebar')
                這是主要的側邊欄。
            @show
            --}}
            <div class="col-md-2 col-md-offset-0">

@yield('sidebar')

            </div>
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
@if(Auth::check())
                    <div class="panel-heading">{!! $page->getCurrentWebRoute() !!}</div>
@else
                    <div class="panel-heading">使用者登入</div>
@endif
                    <div class="panel-body">

{!! $presenter->showStatus(session('status')) !!}

{!! $presenter->showErrors($errors) !!}

@yield('content')
                    </div>
                </div>
                <div class="reflective"></div>
            </div>
            <div class="col-md-2 col-md-offset-0">
@yield('sidebar-right')
            </div>
        </div>
    </div>
</body>
</html>
