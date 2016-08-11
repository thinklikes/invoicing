@extends('layouts.app')

@inject('pagePresenter', 'Page\PagePresenter')

@section('content')

    <!-- Bootstrap 樣板... -->
    @foreach ($pages as $page)

            <a class="btn btn-default" href="{{ action($page->action) }}">
                {{ $page->name }}
            </a>
    @endforeach
    <!-- 代辦：目前任務 -->
@endsection