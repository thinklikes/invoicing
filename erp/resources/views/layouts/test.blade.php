@extends('layouts.app')


@section('content')
    <script type="text/javascript" src="{{ asset('assets/js/OrderCalculator.js') }}"></script>
    <script type="text/javascript">
        var class_name = {
            quantity : 'stock_quantity',
            no_tax_price : 'stock_no_tax_price',
            no_tax_amount : 'stock_no_tax_amount',
            tax_rate_code : 'tax_rate_code',
            total_no_tax_amount : 'total_no_tax_amount',
            tax : 'tax'
            total_amount_class : 'total_amount_class'
        }
        var a = new ValuePullerByHtmlId();
        console.log(a.pull(class_name));
    </script>
@endsection('content')