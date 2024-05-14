<?php

namespace App\Models;

use App\Events\EventProjectUpdated;
use App\Observers\ProjectObserver;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use KirschbaumDevelopment\NovaComments\Commentable;

class Project extends Model
{
    use HasFactory, SoftDeletes,Commentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'project_number',
        'name',
        'category_id',
        'description',
        'deadline_date',
        'deadline_time',
        'deadline_timezone',
        'public_date',
        'deadline_beyond',
        'walkthrough',
        'rfps',
        'addendums',
        'status',
        'admin_id'
    ];

    protected $casts = [
        'rfps' => 'collection',
        'addendums' => 'collection',
        'deadline_date' => 'datetime:Y-m-d',
//        'deadline_time' => 'datetime:H:',
        'public_date' => 'datetime:Y-m-d'
    ];

    protected $appends = ['isLate','deadline_datetime'];


    //protected $dispatchesEvents = [
    //    'updated'  => ProjectObserver::class,
    //    'saved'    => ProjectObserver::class,
    //];

    /**
     * Boot
     */
    public static function boot()
    {
        parent::boot();

    }

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the user that owns the project.
     */
    public function admin()
    {
        return $this->hasOne('App\Models\Admin', 'id', 'admin_id');
    }

    /**
     * Get the user that owns the project.
     */
    public function belongsToAdmin()
    {
        return $this->belongsTo('App\Models\Admin',  'admin_id');
    }

    /**
     * Get the user(client) that owns the project.
     */
    public function userBelongs()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the logs of the project.
     */
    public function logs()
    {
        return $this->hasMany('App\Models\ProjectLog', 'project_id', 'id');
    }

    /**
     * Get the fans of the project.
     */
    public function fans()
    {
        return $this->hasMany('App\Models\ProjectFavorite', 'project_id', 'id');
    }

    /**
     * Get the viewers of the project.
     */
    public function viewers()
    {
        return $this->hasMany('App\Models\ProjectView', 'project_id', 'id');
    }


    /**
     * Get all of the addendums for the project.
     */
    public function projectaddendum()
    {
        return $this->hasMany('App\Models\ProjectAddendum', "project_id", "id");
    }


    /**
     * Get all of the addendums for the project.
     */
    public function projectrfpfile()
    {
        return $this->hasMany('App\Models\ProjectRfpFile', "project_id", "id");
    }

    public function projectrfpfileASCOrder()
    {
        return $this->projectrfpfile()->orderBy('created_at','asc');
    }



    public function projectaddendumASCOrder(){
        return $this->projectaddendum()->orderBy('created_at','asc');
    }


    /**
     * Get the deadline date.
     *
     * @return string
     */
    public function getDeadlineAttribute()
    {
//        return Carbon::parse($this->deadline_date)->format('d-m-Y');
    //    return (new Carbon($this->deadline_date))->format('M d, Y h:i A');
    }

    public function getIsLateAttribute()
    {
        $deadline = new Carbon($this->deadline_datetime);
        return Carbon::now()->gt($deadline);
    }


    /**
     * Get the deadline date only date.
     *
     * @return string
     */
    public function getDeadlineOnlyDateAttribute()
    {
//        return Carbon::parse($this->deadline_date)->format('d-m-Y');
        return (new Carbon($this->deadline_date))->format('M d, Y');
    }

    public function bids(){
        return $this->hasMany(ProjectBid::class,"project_id");
    }

    public function questions(){
        return $this->hasMany(ProjectQuestion::class,"project_id");
    }

    public function vendorBids(){
        return $this->hasMany(ProjectBid::class,"project_id")->where('user_id',Auth::user()->id)->withdraw(false);
    }

    public function getisCategory1Attribute(){
        return str_contains($this->category->name,"Category 1");
    }

    public function getDeadlineDatetimeAttribute()
    {
        $dateTime = Carbon::parse($this->deadline_date)->format('Y-m-d') .' '.$this->deadline_time;
        return ( Carbon::createFromFormat('Y-m-d H:i:s',$dateTime,$this->deadline_timezone))->tz('utc');
    }
}
