@extends('layouts.app')

@section('content')

        <form action="{{ url("/units/$id") }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <table width="100%">
                <tr>
                    <th>料品單位代號</th>
                    <td><input type="text" name="unit[code]" id="code" value="{{ $unit['code'] }}"></td>
                </tr>
                <tr>
                    <th>料品單位說明</th>
                    <td><input type="text" name="unit[comment]" id="comment" value="{{ $unit['comment'] }}"></td>
                </tr>
            </table>
            <button>確認送出</button>
        </form>

@endsection