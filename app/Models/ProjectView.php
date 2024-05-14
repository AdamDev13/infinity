<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectView extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    public $fillable = [
        'project_id',
        'user_id',
        'viewed_at',
    ];

    protected $casts = [
        'project_id' => 'integer',
        'viewed_at' => 'date:Y M d H:m:s'
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
