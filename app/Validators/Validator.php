<?php

namespace App\Validators;

use Illuminate\Database\Eloquent\Model;

abstract class Validator
{
    abstract public function validateCreation(Model $data);
}
;