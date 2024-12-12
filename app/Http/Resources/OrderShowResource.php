<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }

    public function toResponse($request)
    {
        return response()->json([
            'message' => 'order detail successfully imaged',
            'success' => true,
            'data' => $this->toArray($request),
        ], 200);
    }
}
