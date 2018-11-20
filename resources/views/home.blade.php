@extends('layouts.app')

@section('content')
    @foreach ($pages as $page)

            <a class="btn btn-default" href="{{ route($page->route_name) }}">
                {{ $page->name }}
            </a>
    @endforeach
@endsection