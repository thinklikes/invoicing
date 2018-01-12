@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
    @foreach ($pages as $page)

            <a class="btn btn-default" href="{{ route($page->route_name) }}">
                {{ $page->name }}
            </a>
    @endforeach
    <!-- 代辦：目前任務 -->
@endsection