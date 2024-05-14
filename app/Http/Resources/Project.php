<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Project extends JsonResource
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
        $data["projectrfpfile"] = $this->projectrfpfileASCOrder ? new ProjectFileCollection($this->projectrfpfileASCOrder) : [];
        $data["projectaddendum"] =$this->projectaddendumASCOrder ?  new ProjectFileCollection($this->projectaddendumASCOrder) : [];
        $data["is_favorite"] = Auth::user()->projectFavorites()->where('project_id',$this->id)->first()? 1:0;
        if (array_key_exists('vendor_bids',$data)){
           $data['bids'] = new ProjectBidCollection($data["vendor_bids"]);
//           $data['bids'] =  new ProjectBidCollection($data['vendor_bids']);
           unset($data["vendor_bids"]);
        }
        return $data;
    }
}
