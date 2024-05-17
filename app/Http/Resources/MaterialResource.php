<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
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
            'item' => $this->item,
            'price' => $this->price,
            'billing_cycle' => $this->billing_cycle,
            'due_date' => $this->due_date,
            'material' => $this->material,
            'is_multiple' => $this->is_multiple,
        ];
    }
}
