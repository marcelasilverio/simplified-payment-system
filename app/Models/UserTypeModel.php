<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    /** @use HasFactory<\Database\Factories\UserTypeFactory> */
    use HasFactory, SoftDeletes;

    public function users() {
        return $this->hasMany(UserModel::class, 'user_type_id');
    }
}
