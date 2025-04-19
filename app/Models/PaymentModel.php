<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentModel extends Model
{
    use SoftDeletes;

    public const TABLE = 'payments';
    public const ID = 'id';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'value',
    ];

    public function payer(): BelongsTo
    {
        return $this->belongsTo(related: UserModel::class, foreignKey: 'payer_id');
    }

    public function payee(): BelongsTo
    {
        return $this->belongsTo(related: UserModel::class, foreignKey: 'payee_id');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(related: PaymentStatusModel::class, foreignKey: 'status');
    }
}
