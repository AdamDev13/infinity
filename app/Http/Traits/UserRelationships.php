<?php
namespace App\Http\Traits;


trait UserRelationships {
    
    
    /**
     * Get all of the projects for the user.
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project', "user_id", "id");
    }

    
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}"; 
    }


}