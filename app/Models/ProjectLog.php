<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "project_id",
        "user_id",
        "type",
        "event"
    ];


    /**
     * Get the project the log belongs to.
     */
    public function projectBelongs()
    {
        return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }

    /**
     * Get the project that was logged.
     */
    public function project()
    {
        return $this->hasOne('App\Models\Project', 'id', 'project_id');
    }

}
