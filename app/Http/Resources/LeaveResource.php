<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id'            => $this->id,
            'reason'        => $this->reason,
            'discription'   => $this->discription,
            'from'          => $this->from,
            'to'            => $this->to,
            'leave_type'    => $this->leave_type,
            'leave_value'   => $this->leave_value,
            'leave_status'  => $this->leave_status,
        ];
    }
}
