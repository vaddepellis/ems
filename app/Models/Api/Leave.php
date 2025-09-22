<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'reason',
        'discription',
        'from',
        'to',
        'updated_by',
        'leave_type',
        'leave_value',
        'leave_available',
        'leave_used',
        'leave_status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
