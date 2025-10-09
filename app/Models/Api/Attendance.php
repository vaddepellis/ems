<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
   use SoftDeletes;
   protected $fillable = ['in_date', 'in_time', 'out_time','deleted_at'];

   public function user(){
      $this->belongsTo(User::class);
   }
}
