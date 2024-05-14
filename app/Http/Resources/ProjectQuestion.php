<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectQuestion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['created_at'] = (new Carbon($this->created_at))->format('M d, Y H:m:s');
        $data['updated_at'] = (new Carbon($this->updated_at))->format('M d, Y H:m:s');
        return $data;
    }
}
