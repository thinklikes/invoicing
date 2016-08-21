@extends('layouts.app')

@section('content')
    @foreach($users as $user)
        <label>{{ $user->name }}</label>
    @endforeach
@endsection