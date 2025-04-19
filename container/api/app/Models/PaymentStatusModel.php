<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentStatusModel extends Model
{
    use SoftDeletes;

    public const TABLE = 'payments_statuses';
    public const ID = 'id';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
}
