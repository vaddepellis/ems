<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'in_date'=>$this->in_date,
            'in_time'=>$this->in_time,
            'out_time'=>$this->out_time,
            'remarks'=>$this->remarks,
            'sts'=>$this->sts,

        ];
    }
}
