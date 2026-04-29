<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $guarded = ['id'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'member_id');
    }
}


