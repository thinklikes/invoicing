<?php

namespace Erp\Services;

interface CRUDServiceInterface
{
    public function create($listener, $head, $body = null);

    public function update($code, $listener, $head, $body = null);

    public function delete($code, $listener);
}