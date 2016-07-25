@extends('layouts.app')


@section('content')
    <script type="text/javascript" src="{{ asset('assets/js/Sale/combobox.js') }}"></script>
    <script type="text/javascript">
    $().ready(function () {
        $('.company_autocomplete').AjaxCombobox({
            url: '/company/json',
        });
    })
</script>
<input type="text" class="company_autocomplete">
@endsection
