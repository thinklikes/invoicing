@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->
        <form action="{{ url("/system_configs/update") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="50%" border="1">
            @foreach ($configs as $config)
                <tr>
                    <th>{{ $config->comment }}</th>
                    <td><input type="text" name="configs[{{ $config->code }}]" id="{{ $config->code }}" value="{{ $config->value }}" alt="{{ $config->comment }}"></td>
                </tr>
            @endforeach
            </table>
            <button>確認送出</button>
        </form>

@endsection