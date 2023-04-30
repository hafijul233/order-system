<?php

namespace App\Http\Resources;

use App\Models\Company;
use App\Models\Customer;
use Cassandra\Custom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'type' => $this->type ?? '',
            'platform' => $this->platform ?? '',
            'email_verified_at' => $this->email_verified_at ?? null,
            'phone_verified_at' => $this->phone_verified_at ?? null,
            'newsletter_subscribed' => (bool)$this->newsletter_subscribed ?? false,
            'block_reason' => $this->block_reason ?? '',
            'note' => $this->note ?? '',
            'status_html' => $this->status_html ?? '',
            'status_id' => $this->status_id ?? '',
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null,
            'company' => ($this->company instanceof Company) ? $this->company : new \stdClass(),
            'addresses' => ($this->addresses instanceof Collection) ? $this->addresses : [],
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'platforms' => Customer::PLATFORMS,
                'statuses' => Customer::statusDropdown(),
            ],
        ];
    }
}
