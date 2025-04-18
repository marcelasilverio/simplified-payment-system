<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
    ];

    public function payer() {
        return $this->belongsTo(UserModel::class, 'payer_id');
    }

    public function payee() {
        return $this->belongsTo(UserModel::class, 'payee_id');
    }
    public function status() {
        return $this->belongsTo(PaymentStatusModel::class, 'status');
    }
}
