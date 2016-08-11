<?php

namespace Erp\Services;

interface ErpServiceInterface
{
    public function create($master, $details = null);

    public function update($key, $value, $master, $details = null);

    public function delete($key, $value);
}