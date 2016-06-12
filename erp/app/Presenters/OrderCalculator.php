<?php

namespace App\Presenters;

use App\Repositories\OptionRepository;

class OrderCalculator
{
    protected $tax_rate;
    protected $quantity_round_off;
    protected $no_tax_price_round_off;
    protected $no_tax_amount_round_off;
    protected $tax_round_off;
    protected $total_amount_round_off;

    protected $orderMaster;
    protected $orderDetail;

    public function __construct()
    {
        $settings = OptionRepository::getPurchaseOrderSettings();
        $this->purchase_tax_rate       = $settings->purchase_tax_rate;
        $this->quantity_round_off      = $settings->quantity_round_off;
        $this->no_tax_price_round_off  = $settings->no_tax_price_round_off;
        $this->tax_round_off           = $settings->tax_round_off;
        $this->total_amount_round_off  = $settings->total_amount_round_off;
    }

    public function setOrderMaster($orderMaster)
    {
        $this->orderMaster                        = $orderMaster;
        $this->orderMaster['total_no_tax_amount'] = 0;
        $this->orderMaster['tax']                 = 0;
        $this->orderMaster['total_amount']        = 0;
    }

    public function setOrderDetail($orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function calculate()
    {

        //開始計算金額
        foreach ($this->orderDetail as $key => $value) {
            //計算小計
            $this->orderDetail[$key]['no_tax_amount'] = round($this->orderDetail[$key]['quantity'] *
                $this->orderDetail[$key]['no_tax_price'],
                $this->no_tax_price_round_off
            );
            $this->orderMaster['total_no_tax_amount'] += $this->orderDetail[$key]['no_tax_amount'];
        }

        //計算未稅金額
        $this->orderMaster['total_no_tax_amount'] = round($this->orderMaster['total_no_tax_amount'],
            $this->total_amount_round_off
        );

        //計算稅額
        $this->orderMaster['tax'] = round($this->orderMaster['total_no_tax_amount'] *
            $this->purchase_tax_rate,
            $this->tax_round_off
        );

        //計算總金額
        $this->orderMaster['total_amount'] = round($this->orderMaster['total_no_tax_amount'] +
            $this->orderMaster['tax'],
            $this->total_amount_round_off
        );
    }
    public function getNoTaxAmount($index)
    {
        return $this->orderDetail[$index]['no_tax_amount'];
    }
    public function getTotalNoTaxAmount()
    {
        return $this->orderMaster['total_no_tax_amount'];
    }
    public function getTax()
    {
        return $this->orderMaster['tax'];
    }
    public function getTotalAmount()
    {
        return $this->orderMaster['total_amount'];
    }
}