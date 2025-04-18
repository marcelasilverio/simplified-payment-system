<?php

namespace App\Repositories;

abstract class Repository {
    protected Model $model;

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }
}