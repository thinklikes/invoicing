@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/printBarcode.css') }}">
<div class="barcode_container">
@foreach($items as $item)

        <div class="barcode_content">
            <img src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $item->code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
            <br>
            {{ $item->code }} {{ $item->name }}
        </div>

@endforeach
</div>