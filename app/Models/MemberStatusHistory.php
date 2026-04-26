<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStatusHistory extends Model
{
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
