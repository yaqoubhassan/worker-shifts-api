<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
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
            'worker_id' => $this->worker_id,
            'start_time' => Carbon::parse($this->start_time)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::parse($this->end_time)->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
