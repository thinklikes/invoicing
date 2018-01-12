@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/printBarcode.css') }}">
<div class="barcode_container">
@foreach($stocks as $stock)

        <div class="barcode_content">
            <img class="barcode" src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $stock->code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
            <br>
            {{ $stock->code }} {{ $stock->name }}
        </div>

@endforeach
</div>