<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserTypeFactory> */
    use HasFactory, SoftDeletes;

    public const TABLE = 'user_types';
    public const ID = 'id';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    public function users() {
        return $this->hasMany(UserModel::class, 'user_type_id');
    }

    public function canUserTypeTransferMoney() {
        return $this->is_allowed_to_transfer;
    }
}
