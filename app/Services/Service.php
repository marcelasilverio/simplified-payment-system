<?php

namespace App\Services;

use App\Validators\Validator;

abstract class Service {
    protected Validator $validator;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }
};