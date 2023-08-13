<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IssueResource extends JsonResource
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
            'title' => $this->title,
            'type' => $this->type,
            'status' => $this->status,
            'description' => $this->description,
            'tester_id' => $this->tester_id,
            'user_id' => $this->user_id,
            'performer_id' => $this->performer_id,
            'tag_class' => $this->tag_class,
            'class' => get_class($this->resource),
            'trashed' => $this->trashed(),
        ];
    }
}
