<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_image' => $this->profile_api,
            'profile_completed' => $this->profile_completed,
            'orders' => $this->orders,
            'address' => $this->address,
            'province_id' => $this->province_id,
            'province' => $this->province, // Return the full object if needed, or simple name
            'city' => $this->city,
            'country' => $this->country,
            'zip_code' => $this->zip_code,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
