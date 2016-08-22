<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/printtag.css') }}">
<div class="tag_container">
@foreach($companies as $company)

        <div class="tag_content">
            <p class="mailbox">{{ $company->mailbox }}</p>
            <p class="address">{{ $company->company_add }}</p>
            <p class="company_name">{{ $company->company_code }} {{ $company->company_name }}</p>
            <p class="boss">{{ $company->boss }}</p>
        </div>

@endforeach
</div>