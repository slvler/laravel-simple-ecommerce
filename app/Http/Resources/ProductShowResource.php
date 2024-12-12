<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'status' => $this->status
        ];
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => 'Products retrieved successfully',
            'success' => true,
            'data' => $this->toArray($request),
        ], 200);
    }
}