<?php

namespace App\Services;

use App\Validators\Validator;
use App\Repositories\Repository;

abstract class Service {
    protected ?Validator $validator;
    protected Repository $repository;

    public function __construct(Repository $repository, ?Validator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
};