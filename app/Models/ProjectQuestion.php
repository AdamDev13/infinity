<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'question',
        'answer',
        'is_answer',
        'answered_by',
        "is_public"
    ];

//    protected $appends = [
//        'created_at',
//        'updated_at',
//    ];

//    protected $casts = [
//      'created_at' => 'datetime',
//      'updated_at' => 'datetime'
//    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function userBelongs(){
        return $this->belongsTo(Vendor::class,'user_id');
    }

    public function admin(){
        return $this->belongsTo(User::class,'answered_by');
    }

    public function scopePublic($query,$bool = true){
        return $query->where('is_public',true);
    }


}
