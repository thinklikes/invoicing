@extends('layouts.app')

@if (count($sidebar) > 0)
    @section('sidebar')

<div class="panel panel-default">
    <div class="panel-heading">{{ $sidebar['title'] }}</div>

    <div class="panel-body">
        <form action="" method="GET" role="form">
            @foreach ($sidebar['fields'] as $key => $title)
            <div class="form-group">
                <label>{{ $title }}</label>
                <input type="text" class="form-control"
                    name="sidebar[{{ $key }}]"
                    value="{{ $sidebar['data'][$key] or '' }}">
            </div>
            @endforeach
            <button type="submit" class="btn btn-info">{{ $sidebar['button_text'] }}</button>
        </form>
        <br>
    </div>
</div>

    @endsection
@endif

@section('content')

    <!-- Bootstrap 樣板... -->
 <div class="custom-table">
    <div class="thead">
        <div class="tr">
    @foreach ($master['fields'] as $title)
            <div class="th string">{{ $title }}</div>
    @endforeach
        </div>
    </div>
    <div class="tbody">
    @foreach ($master['data'] as $data)
        <div class="tr">
        @foreach ($master['fields'] as $key => $title)
            <div class="td string" data-title="{{ $title }}">
            @if (head($master['fields']) == $title)
                <a href="{{ url('/'.$app_name.'/'.$data->{$key}) }}">
                    {{ $data->{$key} }}
                </a>
            @else
                {{ $data->{$key} }}
            @endif
            </div>
        @endforeach
        </div>
    @endforeach
    </div>
</div>

{{-- <div align="center">{!! $master['paginated'] !!}</div> --}}
<br>
<a class="btn btn-default" href="{{ url("/".$app_name."/create") }}">新增{{ $chname }}</a>
@endsection