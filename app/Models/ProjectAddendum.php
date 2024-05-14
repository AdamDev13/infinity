<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProjectAddendum extends Model
{
    use HasFactory;

    public $fillable = [
        "project_id",
        "label",
        "url",
    ];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function getUrlAttribute($value)
    {
        if (!$value){
            return "";
        }

        if (!Storage::disk('s3')->exists($value)){
            return $value;
        }

        return Storage::disk('s3')->url($value);
    }

}
