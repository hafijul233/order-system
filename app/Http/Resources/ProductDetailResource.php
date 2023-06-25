<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'code' => $this->code ?? '',
            'name' => $this->name ?? '',
            'slug' => $this->slug ?? '',
            'weight' => $this->weight ?? '',
            'default_quantity' => $this->default_quantity ?? '',
            'type' => $this->type ?? '',
            'price' => $this->price ?? '',
            'reorder_level' => $this->reorder_level ?? '',
            'inventory_enabled' => $this->inventory_enabled ?? false,
            'block_reason' => $this->block_reason ?? '',
            'note' => $this->note ?? '',
            'created_at' => $this->created_at ?? '',
            'updated_at' => $this->updated_at ?? '',
        ];
    }
}
