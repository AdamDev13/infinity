<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email',
        'type',
        'first_name',
        'last_name',
        'crm_id',
        'account_number',
        'company_name',
        'phone_number',
        'fax_number',
        'address',
        'address_continued',
        'city',
        'state',
        'county',
        'postal',
        'password'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'web';

    /**
     * Boot
     */
    public static function boot()
    {
        parent::boot();

        self::saved(function(User $model) {
            User::find($model->id)->assignRole($model->type);
        });

        // after deleted
        self::deleted(function($model) {
            // client ? remove all projects
            if($model->type =="client") {
                $model->projects()->each(function($project) {
                    $project->delete();
                });
            }
            // vendor ? remove views, favorites & search preferences
            if($model->type =="vendor") {
                $model->projectViews()->each(function($view) {
                    $view->delete();
                });
                $model->projectFavorites()->each(function($favorite) {
                    $favorite->delete();
                });
                $model->searchPreferences()->each(function($searchpref) {
                    $searchpref->delete();
                });
            }
       });
    }

    /**
     * Get all of the projects for the user.
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project', "user_id", "id");
    }

    /**
     * Get all of the Views for the user.
     */
    public function projectViews()
    {
        return $this->hasMany('App\Models\ProjectView', "user_id", "id");
    }

    /**
     * Get all of the Search Preferences for the user.
     */
    public function searchPreferences()
    {
        return $this->hasMany('App\Models\SearchPreference', "user_id", "id");
    }

    /**
     * Get all of the Favorites for the user.
     */
    public function projectFavorites()
    {
        return $this->hasMany('App\Models\ProjectFavorite', "user_id", "id");
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    /**
     * Get the user's full details.
     *
     * @return string
     */
    public function getfullDetailsAttribute()
    {
        $return ='';
        if($this->company_name) {
            $return = $this->company_name;
        }
        else {
            $return = $this->first_name . ' ' . $this->last_name;
        }
        if($this->address) {
        //    $return .=' | ' . $this->address;
        }
        if($this->city) {
            $return .=' | ' . $this->city;
        }
        if($this->county) {
            $return .=', ' . $this->county;
        }
        if($this->state) {
            $return .=', ' . $this->state;
        }
        return trim($return);
    }


    /**
     * Get the user's full details.
     *
     * @return string
     */
    public function getViewedByAttribute()
    {
        $return ='';
        if($this->company_name) {
            $return = $this->company_name;
        }
        if($this->first_name) {
            $return .= ' | ' . $this->first_name . ' ' . $this->last_name;
        }
        return trim($return);
    }

}
