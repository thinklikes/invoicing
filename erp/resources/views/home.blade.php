@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
    @foreach ($pages as $page)
            <p>
                <a href="{{ action($page->action) }}">{{ $page->name }}</a>
            </p>
    @endforeach
    <!-- 代辦：目前任務 -->
@endsection