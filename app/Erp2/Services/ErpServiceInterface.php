<?php

namespace Erp\Services;

interface ErpServiceInterface
{
    public function create($listener, $head, $body = null);

    public function update($code, $listener, $head, $body = null);

    public function delete($code, $listener);
}