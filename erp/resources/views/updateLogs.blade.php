@extends('layouts.app')

@section('content')

    <ul>
    @foreach($logs as $log)
        <li>{!! str_replace('[visiable]', '<br>', (trim($log))) !!}</li>
    @endforeach
    </ul>
@endsection