<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\LeaveResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'name'      => $this->name,
            'lastname'  => $this->lastname,
            'email'     => $this->email,
            'mobile'    => $this->mobile,
            'leaves'    => LeaveResource::Collection($this->whenLoaded('leaves'))
        ];
    }
}
