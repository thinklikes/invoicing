<?php

use App\Libaries\OrderCalculator;
use Option\OptionRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderCalculatorTest extends TestCase
{
    //使用遷移
    use DatabaseMigrations;

    public function insertDB()
    {
        DB::table('erp_options')->insert([

            [
                'class'   => 'system_configs',
                'code'    => 'purchase_tax_rate',
                'comment' => '進貨稅率',
                'value'   => '0.05',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'sale_tax_rate',
                'comment' => '銷貨稅率',
                'value'   => '0.05',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'quantity_round_off',
                'comment' => '數量小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'no_tax_price_round_off',
                'comment' => '稅前單價小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'no_tax_amount_round_off',
                'comment' => '小計小數點位數',
                'value'   => '2',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'tax_round_off',
                'comment' => '營業稅小數點位數',
                'value'   => '0',
            ],
            [
                'class'   => 'system_configs',
                'code'    => 'total_amount_round_off',
                'comment' => '總計小數點位數',
                'value'   => '0',
            ],
        ]);

        $configs = App::make(OptionRepository::class)->getAllConfigs();
        $output = [];
        foreach ($configs as $key => $value) {
            $output[$value['code']] = $value['value'];
        }
        config([
            'system_configs' => $output
        ]);
        //$this->seeInDatabase('users', ['code' => 'sale_tax_rate']);
    }
    /**
     * 測試OrderCalculator->setValues()
     *
     * @return void
     */
    public function testSetValuesAndCalculateWithoutDiscount()
    {
        //Arrange
        $this->insertDB();

        $a = App::make(OrderCalculator::class);
        $quantity = [1, 2, 3];
        $no_tax_price = [10, 20, 30];

        //Act
        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price
        ]);
        $this->assertTrue($result);
    }
    /**
     * 測試OrderCalculator->setValues()
     *
     * @return void
     */
    public function testSetValuesAndCalculateWithDiscount()
    {
        //Arrange
        $this->insertDB();
        $a = App::make(OrderCalculator::class);

        $quantity = [1, 2, 3];
        $no_tax_price = [10, 20, 30];
        $discount = [80, 90, 0];
        //Act
        $result = $a->setValuesAndCalculate([
            'quantity'         => $quantity,
            'no_tax_price'     => $no_tax_price,
            'discount'         => $discount,
            'discount_enabled' => true
        ]);
        $this->assertTrue($result);
    }

    /**
     * 測試OrderCalculator->setValues()
     * 當quantity與no_tax_price數量不符時要跳出錯誤
     * @return void
     */
    public function testSetValuesAndCalculateNotMatch()
    {
        //Arrange
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [1, 2, 3];
        $no_tax_price = [10, 30];

        //Act
        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $this->assertEquals($result, "參數數量不一致");
    }

    /**
     * 測試OrderCalculator->getNoTaxAmount()
     */
    public function testGetNoTaxAmount_1()
    {
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [1, 2, 3];
        $no_tax_price = [10, 20, 30];

        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $expected = [
            round(10, 2),
            round(40, 2),
            round(90, 2)
        ];
        $this->assertEquals($expected[0], $a->getNoTaxAmount(0));
        $this->assertEquals($expected[1], $a->getNoTaxAmount(1));
        $this->assertEquals($expected[2], $a->getNoTaxAmount(2));
    }

    /**
     * 測試OrderCalculator->getNoTaxAmount()
     * 取得每一列的未稅金額
     */
    public function testGetNoTaxAmount_2()
    {
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [2, 4, 6];
        $no_tax_price = [10, 20, 30];

        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $expected = [
            round(20, 2),
            round(80, 2),
            round(180, 2)
        ];
        $this->assertEquals($expected[0], $a->getNoTaxAmount(0));
        $this->assertEquals($expected[1], $a->getNoTaxAmount(1));
        $this->assertEquals($expected[2], $a->getNoTaxAmount(2));
    }
    /**
     * 測試OrderCalculator->getTotalNoTaxAmount()
     * 取得未稅金額的總額
     */
    public function testGetTotalNoTaxAmount()
    {
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [2, 4, 6];
        $no_tax_price = [10, 20, 30];

        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $expected = round(280, 2);
        $this->assertEquals($expected, $a->getTotalNoTaxAmount());
    }

    /**
     * 測試OrderCalculator->getTax()
     * 取得總金額
     */
    public function testGetTax()
    {
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [2, 4, 6];
        $no_tax_price = [10, 20, 30];

        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $expected = round(14, 2);
        $this->assertEquals($expected, $a->getTax());
    }
    /**
     * 測試OrderCalculator->getTotalAmount()
     * 取得總金額
     */
    public function testGetTotalAmount()
    {
        $this->insertDB();
        $a = App::make(OrderCalculator::class);
        $quantity = [2, 4, 6];
        $no_tax_price = [10, 20, 30];

        $result = $a->setValuesAndCalculate([
            'quantity' => $quantity,
            'no_tax_price' => $no_tax_price,
        ]);
        $expected = round(294, 2);
        $this->assertEquals($expected, $a->getTotalAmount());
    }
}
