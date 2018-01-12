{{-- 注入倉庫選項的檔案 --}}
@inject('WarehousePresenter', 'Warehouse\WarehousePresenter')


@extends('layouts.app')

@section('content')
    @foreach ($data as $key => $dataRow)
        <table class="table">
            <tr>
                <th width="150px">銷貨單號</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->code or null }}
                </td>
            </tr>
            <tr>
                <th width="150px">客戶訂單號碼</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->customerOrderCode or null}}
                </td>
            </tr>
            <tr>
                <th width="150px">出貨倉庫</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->warehouse->name or null}}
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <th width="150px">客戶</th>
                <td>{{-- 放入這次客戶登記的資料 --}}
                    {{ $dataRow['billOfSaleMaster']->company->company_code or null}}
                    {{ $dataRow['billOfSaleMaster']->company->company_name or null}}
                </td>
            </tr>
            <tr>
                <th width="150px">公司電話</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->company->company_tel or null}}
                </td>
            </tr>
            <tr>
                <th width="150px">公司地址</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->company->company_add or null}}
                </td>
            </tr>
            <tr>
                <th width="150px">聯絡人</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->company->company_contact or null}}
                </td>
            </tr>
            <tr>
                <th width="150px">聯絡人電話</th>
                <td>
                    {{ $dataRow['billOfSaleMaster']->company->company_con_tel or null}}
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <th>料品代號</th>
                <th>料品名稱</th>
                <th>數量</th>
                <th>含稅單價</th>
                <th>金額</th>
            </tr>
            @foreach ($dataRow['billOfSaleDetail'] as $detail)
            <tr>
                <td>
                    {{ $detail->stock->code or null}}
                </td>
                <td>
                    {{ $detail->stock->name or null}}
                </td>
                <td>
                    {{ $detail->quantity or null}}
                </td>
                <td>
                    {{ $detail->price_tax or null}}
                </td>
                <td>
                    {{ ($detail->quantity * $detail->price_tax) }}
                </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="4">總計</th>
                <td>
                    {{
                        $dataRow['billOfSaleDetail']->sum(function ($item) {
                            return $item->quantity * $item->price_tax;
                        })
                    }}
                </td>
        </table>
        <div style="border:0.5px black solid;"></div>
    @endforeach
    <a class="btn btn-default" href="{{ url("/orderTranslater") }}">回上一頁</a>
@endsection
