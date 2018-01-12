@inject('BarcodeGenerator', 'Picqer\Barcode\BarcodeGeneratorJPG')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/printBarcode.css') }}">
<div class="barcode_container">
@foreach($companies as $company)

        <div class="barcode_content">
            <img class="barcode" src="data:image/png;base64,
                {{
                    base64_encode(
                        $BarcodeGenerator->getBarcode(
                            $company->company_code,
                            $BarcodeGenerator::TYPE_CODE_128
                        )
                    )
                }}">
            <br>
            {{ $company->company_code }} {{ $company->company_name }}
        </div>

@endforeach
</div>