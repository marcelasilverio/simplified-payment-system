<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    public const TABLE = 'users';
    public const ID = 'id';

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(related: UserTypeModel::class, foreignKey: 'user_type_id');
    }

    public function canTransferMoney(): bool
    {
        return $this->type && $this->type->canUserTypeTransferMoney();
    }
}
