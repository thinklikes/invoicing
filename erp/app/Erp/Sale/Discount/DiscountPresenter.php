<?php
namespace Sale\Discount;

use Option\OptionRepository as Repository;
/**
 * 產生折扣選項
 */
class DiscountPresenter {
    protected $repository;

    public function __construct(Repository $repository) {
        $this->repository = $repository;
    }

    public function renderOptions($discount = '') {
        $options = $this->repository->getOptionsByClass('discount');
        $options_html = '';
        foreach ($options as $key => $value) {
            $options_html .= '<option value="'.$value->value.'"';
            $options_html .= ($value->value == $discount ? " selected>" : ">");
            $options_html .= $value->comment . '</option>';
        }
        return $options_html;
    }

    public function getCommentByDiscountValue($value)
    {
        //$value = sprintf()

        return $this->repository->getCommentByValue('discount', $value);
    }
}