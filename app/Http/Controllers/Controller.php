<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected Service $service;

    public function __construct(Service $service) {
        $this->service = $service;
    }
}
