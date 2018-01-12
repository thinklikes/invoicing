@inject('page', 'App\Presenters\PagePresenter')
@inject('presenter', 'App\Presenters\StatusPresenter')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('system_configs.website_title') }}</title>
</head>
<body id="app-layout">

@yield('content')

</body>
</html>
