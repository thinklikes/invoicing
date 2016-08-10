@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->


            <a class="btn btn-default" href="{{ action('PageController@index') }}">
                進銷存系統
            </a>

            <a class="btn btn-default" href="/CRM/company_system.php">
                客戶關係管理系統
            </a>

@endsection