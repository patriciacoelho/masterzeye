<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public static $wrap = 'project';

    public function resolve($request = null): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'value' => $this->value,
            'status' => $this->when(isset($this->status), $this->status, 'active'),
            'creator' => optional($this->user)
                ->only('id', 'name', 'email'),
        ];
    }
}
