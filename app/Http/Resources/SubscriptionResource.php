<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'is_active' => $this->is_active,
            'is_new' => $this->is_new,
            'expiration_date' => $this->expiration_date,
            'subscription_package_id' => $this->subscription_package_id,
            'package' => $this->package
        ];
    }
}
