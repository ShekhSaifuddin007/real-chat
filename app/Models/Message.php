<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function fromUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
