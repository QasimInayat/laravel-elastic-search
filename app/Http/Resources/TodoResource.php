<?php

// app/Http/Resources/TodoResource.php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'description'=> $this->description,
            'is_done'    => (bool) $this->is_done,
            'due_date'   => $this->due_date,
            'priority'   => $this->priority,
            'image' => [
                'original' => $this->getFirstMediaUrl('image', 'watermarked'),
                'thumb'    => $this->getFirstMediaUrl('image', 'thumb'),
                'medium'   => $this->getFirstMediaUrl('image', 'medium'),

            ],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}

