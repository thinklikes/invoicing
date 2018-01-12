@extends('layouts.app')

@section('content')
    @foreach($platforms as $platform)
        <a class="btn btn-default" href="{{ url('/itemMappingEditor/'.$platform->name) }}">{{ $platform->name }}</a>
    @endforeach
@endsection