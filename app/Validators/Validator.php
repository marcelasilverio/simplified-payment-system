<?php

namespace App\Validators;

use App\Exceptions\InvalidValidatorModelException;
use Illuminate\Database\Eloquent\Model;

abstract class Validator {
    abstract public function validateCreation(Model $data);
};