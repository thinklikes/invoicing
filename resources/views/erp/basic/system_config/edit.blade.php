@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
        <form action="{{ url("/system_config/update") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="50%" class="table">
            @foreach ($configs as $config)
                <tr>
                    <th>{{ $config->comment }}</th>
                    <td><input type="text" name="configs[{{ $config->code }}]" id="{{ $config->code }}" value="{{ $config->value }}" alt="{{ $config->comment }}"></td>
                </tr>
            @endforeach
            </table>
            <button class="btn btn-default">確認送出</button>
        </form>

@endsection