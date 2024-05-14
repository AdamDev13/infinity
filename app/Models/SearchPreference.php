<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchPreference extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        "user_id",
        "category_id",
        "state",
        "county",
        "city",
    ];

    /**
     * Get the user that owns the search preferences.
     */
    public function userBelongs()
    {
        return $this->belongsTo('App\Models\Vendor', 'user_id', 'id');;
    }

    /**
     * Get the user that owns the preferences.
     */
    public function user()
    {
        return $this->hasOne('App\Models\Vendor', 'id', 'user_id');
    }

    /**
     * Get the category.
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
    
}
