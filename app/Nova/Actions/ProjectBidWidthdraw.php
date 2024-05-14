<?php

namespace App\Nova\Actions;

use App\Mail\BidWithdraw;
use App\Models\ProjectBid;
use App\Models\ProjectFavorite;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Actions\DestructiveAction;

class ProjectBidWidthdraw extends Action
{
    use InteractsWithQueue, Queueable;

    public $withoutConfirmation = true;
    public function __construct()
    {
        $this->confirmButtonText = 'Withdraw Bid';
        $this->confirmText = 'Do you really want to withdraw from this project?';
        $this->withoutConfirmation = true;
    }
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model) {
            $projectBid = ProjectBid::find($model->id);
            if (Carbon::now()->gt($projectBid->project->deadline_datetime)){
                return $this->danger('Bid cannot be withdraw after deadline');
            }
            $projectBid->is_withdraw = true ;
            $projectBid->save();
            return $this->message('withdraw successfully');
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
