<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProjectBid extends Model
{
    use HasFactory;

    public $fillable = [
        "project_id",
        "label",
        "url",
        "user_id",
        "base_price",
        "contingency_fee",
        "status",
        "is_withdraw",
        "is_approved",
        "note",
        "monthly_cost",
        "monthly_tax_cost",
        "non_recurring_cost",
        "term_of_contract_month",
        "timezone"
    ];

    protected $appends = [
        'total', 'submission_date'
    ];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function userBelongs()
    {
        return $this->belongsTo(Vendor::class, 'user_id', 'id');
    }

    public function getTotalAttribute()
    {
        if ($this->base_price != "" && $this->contingency_fee != "") {
            return $this->base_price + $this->contingency_fee;
        }

        return ((floatval($this->monthly_cost) + floatval($this->monthly_tax_cost)) * intval($this->term_of_contract_month)) + floatval($this->non_recurring_cost);
    }

    public function getSubmissionDateAttribute()
    {
//        return $this->created_at;
        return (new Carbon($this->created_at))->format('M d, Y g:i A');
    }

    public function getfileUrlAttribute()
    {
        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            return Storage::disk('s3')->url($this->url);
        }
        return $this->url;
    }

    public function getStatusNameAttribute()
    {
        return $this->statuses()[$this->status];
    }


    public function scopeWithdraw($query, $value = true)
    {
        return $query->where('is_withdraw', $value);
    }


    public function statuses(): array
    {
        return [
            'RE' => 'Recommended',
            'R' => 'Rejected',
            'L' => 'Late Bid',
            'A' => 'Active',
        ];
    }

    public function attachments(){
        return $this->hasMany(ProjectBidAttachment::class,'project_bid_id');
    }



//    public function getUrlAttribute($value)
//    {
//        if (!filter_var($value, FILTER_VALIDATE_URL)) {
//            return url(Storage::url($value));
//        }
//        return $value;
//    }

}
