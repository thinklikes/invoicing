<?php

namespace App\Libaries;

use Config;

class OrderCalculator
{
    //設定參數
    private $tax_rate_code           = '';
    private $tax_rate                = 0;
    private $quantity_round_off      = 0;
    private $no_tax_price_round_off  = 0;
    private $no_tax_amount_round_off = 0;
    private $tax_round_off           = 0;
    private $total_amount_round_off  = 0;

    //設定各項計算的數據變數
    //因為放進來的單價固定是打完折的未稅單價
    //所以不用倒推稅內含與原價
    private $quantity = array();
    private $no_tax_price = array();
    private $no_tax_amount = array();
    private $total_no_tax_amount = 0;
    private $tax = 0;
    private $total_amount = 0;

    public function __construct()
    {
        $this->tax_rate                = config('system_configs')['sale_tax_rate'];
        $this->quantity_round_off      = config('system_configs')['quantity_round_off'];
        $this->no_tax_price_round_off  = config('system_configs')['no_tax_price_round_off'];
        $this->no_tax_amount_round_off = config('system_configs')['no_tax_amount_round_off'];
        $this->tax_round_off           = config('system_configs')['tax_round_off'];
        $this->total_amount_round_off  = config('system_configs')['total_amount_round_off'];
    }

    public function setValuesAndCalculate($data)
    {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
        //檢查數量有沒有一致
        $success = false;

        try {

            $ql   = count($this->quantity);
            $ntpl = count($this->no_tax_price);
            if ($ql != $ntpl) {
                //調用PHP原生的例外class
                throw new \Exception("參數數量不一致");
            }
            $success = true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $success && $this->calculate();
        return true;
    }

    private function calculate()
    {
        //開始計算金額
        foreach ($this->quantity as $key => $value) {
            if (!($value && $this->no_tax_price[$key])) {
                continue;
            }
            //計算小計

            $this->no_tax_amount[$key] = round(
                $this->quantity[$key] * $this->no_tax_price[$key],
                $this->no_tax_amount_round_off
            );
            $this->total_no_tax_amount += $this->no_tax_amount[$key];
        }

        //計算未稅金額
        $this->total_no_tax_amount = round($this->total_no_tax_amount,
            $this->total_amount_round_off
        );

        //計算稅額
        $this->tax = round($this->total_no_tax_amount *
            $this->tax_rate,
            $this->tax_round_off
        );
        //若是免稅，就把稅額設定為0
        if ($this->tax_rate_code == 'N') {
            $this->tax = 0;
        }

        //計算總金額
        $this->total_amount = round($this->total_no_tax_amount +
            $this->tax, $this->total_amount_round_off
        );
    }
    public function getNoTaxAmount($index)
    {
        if (!isset($this->no_tax_amount[$index])) {
            return '';
        }
        return $this->no_tax_amount[$index];
    }
    public function getTotalNoTaxAmount()
    {
        return $this->total_no_tax_amount;
    }
    public function getTax()
    {
        return $this->tax;
    }
    public function getTotalAmount()
    {
        return $this->total_amount;
    }
}