<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    public static $wrap = 'projects';

    public function toArray($request)
    {
        return $this->resource->transform(fn (ProjectResource $project) => [
            'id' => $project->id,
            'name' => $project->name,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'status' => $project->status,
            'value' => $project->value,
            'creator_name' => $project->user->name,
            'updated_at' => $project->updated_at->format('Y-m-d'),
        ]);
    }
}
