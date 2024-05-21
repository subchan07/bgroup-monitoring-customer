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
            'service' => $this->service,
            'domain' => $this->domain,
            'due_date' => $this->due_date,
            'price' => $this->price,
            'hosting_material_id' => $this->hosting_material_id,
            'ssl_material_id' => $this->ssl_material_id,
            'domain_material_ids' => $this->domainMaterials->pluck('id'),
            'domainMaterials' => MaterialResource::collection($this->whenLoaded('domainMaterials')),
            'hostingMaterial' => new MaterialResource($this->whenLoaded('hostingMaterial')),
            'sslMaterial' => new MaterialResource($this->whenLoaded('sslMaterial')),
        ];
    }
}
