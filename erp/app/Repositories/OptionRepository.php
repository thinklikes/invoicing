<?php

namespace App\Repositories;

use App\Option;

use DB;

class OptionRepository
{
    public static function getPurchaseOrderFormat()
    {
        $format = Option::select('value')
            ->where('code', 'purchase_order_format')
            ->value('value');
        return $format;
    }

    public static function getPurchaseOrderSettings()
    {
        $configs = Option::select('code', 'value')
            //->where('class', 'system_configs')
            ->whereIn('code',
                [
                    'purchase_tax_rate',
                    'quantity_round_off',
                    'no_tax_price_round_off',
                    'no_tax_amount_round_off',
                    'tax_round_off',
                    'total_amount_round_off'
                ]
            )
            ->get();
        $settings = (object)[];
        foreach ($configs as $config) {
            $settings->{$config->code} = $config->value;
        }
        return $settings;
    }

    public static function getAllConfigs()
    {
        $configs = Option::select('code', 'value', 'comment')
            ->where('class', 'system_configs')
            ->get();
        return $configs;
    }
    /**
     * 找出網站標題
     * @return string 網站標題的內容
     */
    public static function getWebSiteTitle()
    {
        $website_title = Option::select('value')
            ->where('code', 'website_title')
            ->value('value');
        return $website_title;
    }
    /**
     * 更新所有SystemConfigs
     * @param [type] $configs [description]
     */
    public static function setSystemConfigs($configs)
    {
        foreach ($configs as $code => $value) {
            Option::where('class', 'system_configs')
                ->where('code', $code)
                ->update(['value' => $value]);
        }
    }

    /**
     * find all options
     * @return array all options
     */
    public static function getAllOptionsId($class)
    {
        $options = Option::select('id')
            ->where('class', $class)
            ->get()->toArray();
        //array_flatten() => 將多維的陣列轉成一維陣列
        $options = array_flatten($options);
        return $options;
    }

    /**
     * find all pair options = id:fullcomment
     * @return array all options
     */
    public static function getAllOptionsPair($class)
    {
        $options = Option::select(
                DB::raw('concat(code, " ",comment) as full_comment, id')
            )
            ->where('class', $class)
            ->lists('full_comment', 'id');
        return $options;
    }
    /**
     * find a page of options
     * @return array all options
     */
    public static function getOptionsOnePage($class)
    {
        $options = Option::where('class', $class)
            ->paginate(15);
        return $options;
    }
    /**
     * find detail of one option
     * @param  integer $id The id of option
     * @return array       one option
     */
    public static function getOptionDetail($class, $id)
    {
        $options = Option::where('id', $id)
            ->where('class', $class)
            ->firstOrFail();
        return $options;
    }

    /**
     * store a option
     * @param  integer $id The id of option
     * @return void
     */
    public static function storeOption($class, $option)
    {
        $new_option = new Option;
        $new_option->class = $class;
        foreach($option as $key => $value) {
            $new_option->{$key} = $value;
        }
        $new_option->save();
        return $new_option->id;
    }

    /**
     * update a Option
     * @param  integer $id The id of option
     * @return void
     */
    public static function updateOption($class, $option, $id)
    {
        $tmp_option = Option::where('class', $class)
            ->findOrFail($id);
        foreach($option as $key => $value) {
            $tmp_option->{$key} = $value;
        }
        $tmp_option->save();
    }

    /**
     * delete a Option
     * @param  integer $id The id of option
     * @return void
     */
    public static function deleteOption($class, $id)
    {
        $tmp_option = Option::where('class', $class)
            ->findOrFail($id);
        $tmp_option->delete();
    }
}