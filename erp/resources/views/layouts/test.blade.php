@extends('layouts.app')

@inject('SupplierRepository', 'App\Repositories\SupplierRepository')
@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
@section('content')
    @foreach($SupplierRepository->getSuppliersOnePage([]) as $key => $value)
    <p>{{ $value['name'] }} <img src="data:image/png;base64, {{ base64_encode($BarcodeGenerator->getBarcode($value['code'], $BarcodeGenerator::TYPE_CODE_128)) }}"></p>
    @endforeach
@endsection('content')