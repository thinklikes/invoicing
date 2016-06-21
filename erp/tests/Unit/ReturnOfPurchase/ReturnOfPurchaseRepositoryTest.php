<?php
use App\Basic\Supplier;
use App\Repositories\Basic\ReturnOfPurchaseRepository;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReturnOfPurchaseRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_method_getSuppliersPaginated()
    {
    }
}