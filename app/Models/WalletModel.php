<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletModel extends Model
{
    public const TABLE = 'wallets';
    public const ID = 'id';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        'user_id',
        'balance'
    ];

    public function user() {
        return $this->belongsTo(UserTypeModel::class, 'user_id');
    }
}
