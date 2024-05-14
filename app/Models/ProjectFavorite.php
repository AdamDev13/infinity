<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFavorite extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "user_id",
        "project_id",
        "status",
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the project that was viewd.
     */
    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

    
}
