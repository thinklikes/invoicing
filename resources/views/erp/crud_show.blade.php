@extends('layouts.app')

@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')

@include('erp.show_button_group', [
    'print_enabled'  => false,
    'delete_enabled' => true,
    'edit_enabled'   => true,
    'chname'         => $chname,
    'route_name'     => $app_name,
    'code'           => $code
])

@section('content')
{{--
     <div style="float:right; margin-bottom:10px;">
            <img src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $company->company_code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
        </div>
--}}

    <div id="haed" class="custom-table">
    @foreach ($head['fields'] as $key => $item)

        <div class="tr">
            <div class="th">{{ $item['title'] }}</div>
            <div class="td" data-title="{{ $item['title'] }}">
                {{ $head['data'][$key] }}
            </div>
        </div>

    @endforeach
    </div>
    @yield('show_button_group')
@endsection