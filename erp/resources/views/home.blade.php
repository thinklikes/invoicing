@extends('layouts.app')

@inject('pagePresenter', 'App\Page\PagePresenter')

@section('content')

    <!-- Bootstrap 樣板... -->
    @foreach ($pages as $page)
            <p>
                <a href="{{ $pagePresenter->getPageAction($page) }}">
                    {{ $page->name }}
                </a>
            </p>
    @endforeach
    <!-- 代辦：目前任務 -->
@endsection