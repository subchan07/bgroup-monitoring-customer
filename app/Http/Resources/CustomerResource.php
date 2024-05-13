<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'domain' => $this->domain,
            'due_date' => $this->due_date,
            'price' => $this->price,
            'domain_material_id' => $this->domain_material_id,
            'hosting_material_id' => $this->hosting_material_id,
            'ssl_material_id' => $this->ssl_material_id,
            'domainMaterial' => new MaterialResource($this->whenLoaded('domainMaterial')),
            'hostingMaterial' => new MaterialResource($this->whenLoaded('hostingMaterial')),
            'sslMaterial' => new MaterialResource($this->whenLoaded('sslMaterial')),
        ];
    }
}
