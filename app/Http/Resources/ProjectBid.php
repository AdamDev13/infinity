<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectBid extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $data['url'] = Storage::disk('s3')->url($data['url']);
        }
        if (array_key_exists('attachments', $data) && $data['attachments']) {
            $data['attachments'] = new ProjectFileCollection($data['attachments']);
        }
        return $data;
    }
}
