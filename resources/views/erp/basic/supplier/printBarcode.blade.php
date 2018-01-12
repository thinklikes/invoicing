@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/printBarcode.css') }}">
<div class="barcode_container">
@foreach($suppliers as $supplier)

        <div class="barcode_content">
            <img class="barcode" src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $supplier->code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
            <br>
            {{ $supplier->code }} {{ $supplier->name }}
        </div>

@endforeach
</div>