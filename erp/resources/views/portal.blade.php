@extends('layouts.app')

@section('content')

    <!-- Bootstrap 樣板... -->

        <p>
            <a href="{{ action('PageController@index') }}">erp</a>
        </p>
        <p>
            <a href="/CRM/company_system.php">CRM</a>
        </p>
@endsection