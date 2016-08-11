@extends('layouts.app')
@inject('presenter', 'App\Presenters\PublicPresenter')

@if (count($sidebar) > 0)
    @section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">{{ $sidebar['title'] }}</div>

    <div class="panel-body">
        <form action="" method="GET" role="form">
            @foreach ($sidebar['item'] as $item)
                {!! $presenter->renderFormElement($item) !!}
            @endforeach
            <button type="submit" class="btn btn-info">{{ $sidebar['button_text'] }}</button>
        </form>
        <br>
        <a class="btn btn-default" href="/company/printBarcode" target="_blank">條碼列印</a>
    </div>
</div>

    @endsection
@endif
@section('content')

    <!-- Bootstrap 樣板... -->
<div id="detail_table" class="custom-table table">
    <div class="thead">
        <div class="tr">
    @foreach ($master['title'] as $title)
            <div class="th">{{ $title }}</div>
    @endforeach
        </div>
    </div>
    <div class="tbody">
    @foreach ($master['item'] as $item)
        <div class="tr">
        @foreach ($master['title'] as $key => $title)
            <div class="td" data-title="{{ $title }}">{{ $item->{$key} }}</div>
        @endforeach
        </div>
    @endforeach
    </div>
</div>

<div align="center">{!! $master['paginated'] !!}</div>
<br>
<a class="btn btn-default" href="{{ $app_name }}/create">新增{{ $chname }}</a>
@endsection