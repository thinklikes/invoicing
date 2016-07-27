<?php
namespace SaleReport;

/**
 * 對帳單的顯示邏輯
 */
class SaleReportPresenter
{
    /**
     * 回傳單據類型的中文名稱
     * @param  string $class_name 此資料model的class name
     * @return string             單據類型的中文名稱
     */
    public function getOrderLocalNameByOrderType($class_name)
    {
        switch ($class_name) {
            case 'BillOfSaleMaster':
                return '銷貨';
                break;
            case 'ReturnOfSaleMaster':
                return '銷退';
                break;
            default:
                return '';
                break;
        }
    }

    public function makeTableBody($data = null)
    {
        if (count($data) == 0) {
            return '';
        }
        $tbody = '<br>';
        $tbody .= '<table width="80%" style="margin: 0px auto;">';
        $tbody .= '<thead>';
        $tbody .= '<tr>';
        $tbody .= '<th class="string">產品編號</th>';
        $tbody .= '<th class="string">產品名稱</th>';
        $tbody .= '<th class="numeric">數量</th>';
        $tbody .= '<th class="string">單位</th>';
        $tbody .= '<th class="numeric">未稅單價</th>';
        $tbody .= '<th class="numeric">小計</th>';
        $tbody .= '</thead>';
        $tbody .= '<tbody>';

        foreach($data->orderDetail as $key => $value) {
            $i = 0;

            $tbody .= "<tr>";

            $tbody .= "<td class=\"string\">".$value->stock->code."</td>";
            $tbody .= "<td class=\"string\">".$value->stock->name."</td>";
            $tbody .= "<td class=\"numeric\">".$value->quantity."</td>";
            // //$tbody .= "<td class=\"string\">".$value->orderDetail->stock->code ."</td>";
            $tbody .= "<td class=\"string\">".$value->stock->unit->comment ."</td>";
            $tbody .= "<td class=\"numeric\">".$value->no_tax_price ."</td>";
            $tbody .= "<td class=\"numeric\">".$value->subTotal."</td>";
            $tbody .= "</tr>";

        }
        $tbody .= '</tbody>';
        $tbody .= '</table>';
        return $tbody;
    }
}