<?php

namespace App\Repositories;

use App\TaxRate;

use DB;

class TaxRateRepository
{
    /**
     * find all tax_rates
     * @return array all tax_rates
     */
    public static function getAllTaxRate()
    {
        $tax_rates = TaxRate::select(
                DB::raw('concat(code, " ",comment) as full_comment, id')
            )->lists('full_comment', 'id');
        return $tax_rates;
    }
    /**
     * find a page of tax_rates
     * @return array all tax_rates
     */
    public static function getTaxRatesOnePage()
    {
        $tax_rates = TaxRate::paginate(15);
        return $tax_rates;
    }
    /**
     * find detail of one tax_rate
     * @param  integer $id The id of tax_rate
     * @return array       one tax_rate
     */
    public static function getTaxRateDetail($id)
    {
        $tax_rates = TaxRate::where('id', $id)->get();
        return $tax_rates->first();
    }

    /**
     * store a tax_rate
     * @param  integer $id The id of tax_rate
     * @return void
     */
    public static function storeTaxRate($tax_rate)
    {
        $new_tax_rate = new TaxRate;
        foreach($tax_rate as $key => $value) {
            $new_tax_rate->{$key} = $value;
        }
        $new_tax_rate->save();
        return $new_tax_rate->id;
    }

    /**
     * update a tax_rate
     * @param  integer $id The id of tax_rate
     * @return void
     */
    public static function updateTaxRate($tax_rate, $id)
    {
        $tmp_tax_rate = TaxRate::find($id);
        foreach($tax_rate as $key => $value) {
            $tmp_tax_rate->{$key} = $value;
        }
        $tmp_tax_rate->save();
    }

    /**
     * delete a tax_rate
     * @param  integer $id The id of tax_rate
     * @return void
     */
    public static function deleteTaxRate($id)
    {
        $tmp_tax_rate = TaxRate::find($id);
        $tmp_tax_rate->delete();
    }
}