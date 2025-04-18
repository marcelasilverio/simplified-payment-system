<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository {
    protected Model $model;

    public function __construct(Model $model) 
    {
        $this->model = $model;
    }
}