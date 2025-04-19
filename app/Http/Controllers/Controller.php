<?php

namespace App\Http\Controllers;

use App\Services\Service;

abstract class Controller
{
    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
