<?php
namespace Tests\Unit\Erp\Basic\Option;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Option\OptionRepository as Repository;
use Tests\TestCase;

class OptionRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var Repository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
        $this->repository = $this->app->make(Repository::class);
    }

    public function testGetOptionsOnePage()
    {

    }

    public function testUpdateOption()
    {

    }

    public function testGetCommentByValue()
    {

    }

    public function testGetPurchaseOrderFormat()
    {

    }

    public function testGetOptionsByClass()
    {

    }

    public function testGetAllConfigs()
    {

    }

    public function testGetOptionDetail()
    {

    }

    public function testGetAllOptionsPair()
    {

    }

    public function testGetAllOptionsId()
    {

    }

    public function testGetWebSiteTitle()
    {
        $type = gettype($this->repository->getWebSiteTitle());
        $this->assertEquals('string', $type);
    }

    public function testStoreOption()
    {

    }

    public function testDeleteOption()
    {

    }

    public function testGetPurchaseOrderSettings()
    {

    }

    public function testSetSystemConfigs()
    {

    }
}
