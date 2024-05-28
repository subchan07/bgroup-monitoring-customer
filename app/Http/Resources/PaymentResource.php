<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'material_id' => $this->material_id,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
            'due_date' => $this->due_date,
            'price' => $this->price,
            'payment_amount' => $this->payment_amount,
            'status' => $this->status,
            'file' => $this->file,
            'material' => new MaterialResource($this->material),
            'customer' => new CustomerResource($this->customer),
        ];
    }
}
