<?php

namespace App\Validators;

use App\Exceptions\InvalidValidatorModelException;
use App\Models\Model;

abstract class Validator {
    abstract public function validateCreation(Model $data);
};