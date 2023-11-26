<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
            'sciname' => $this->sciname,
            'tradename' => $this->tradename,
            'manufacturer' => $this->manufacturer,
            'qtn' => $this->qtn,
            'expiry' => $this->expiry,
            'price' => $this->price,
        ];
    }
}
