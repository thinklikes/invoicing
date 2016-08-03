@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
        <table width="50%" class="table">
        @foreach ($configs as $config)
            <tr>
                <th>{{ $config->comment }}</th>
                <td>{{ $config->value }}</td>
            </tr>
        @endforeach
        </table>
        <a href="{{ url('/system_config/edit') }}" class="btn btn-default">開始編輯</a>
@endsection