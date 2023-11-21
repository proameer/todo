<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
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
            'note' => $this->note,
            'is_done' => $this->is_done,
            'date_done' => $this->date_done,
            // 'type_name' => $this->todoType->name,
            'todo_type' => new TodoTypeResource($this->todoType),
        ];
    }
}
