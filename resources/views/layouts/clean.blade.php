@inject('page', 'Page\PagePresenter')
@inject('presenter', 'App\Presenters\StatusPresenter')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('system_configs.website_title') }}</title>

</head>
<body id="app-layout">

@yield('content')

</body>
</html>
