<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectBidAttachment extends Model
{
    use HasFactory;

    public $fillable = [
        "project_bid_id",
        "label",
        "url",
    ];

    /**
     * Get the project.
     */
    public function projectBid()
    {
        return $this->belongsTo(ProjectBid::class, 'project_bid_id', 'id');
    }

    public function getfileUrlAttribute()
    {
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            return Storage::disk('s3')->url($this->url);
        }
        return $this->url;
    }


}
