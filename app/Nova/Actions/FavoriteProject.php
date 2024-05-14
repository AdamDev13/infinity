<?php

namespace App\Nova\Actions;

use App\Models\ProjectFavorite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class FavoriteProject extends Action
{
//    use InteractsWithQueue, Queueable;

    public $withoutConfirmation = true;
    
    public function __construct()
    {
        $this->confirmButtonText = 'Add Project';
        $this->confirmText = 'Project will be added to your favorites list.';
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
            $ProjectFavorite = ProjectFavorite::where('project_id', $model->id)
                ->where('user_id',  Auth()->user()->id)
                ->first();
            if($ProjectFavorite) {
                if($ProjectFavorite->status == "active") {
                    $ProjectFavorite->status = "notactive";
                    $ProjectFavorite->save();
                    return $this->message('Project has been unfavorited!');
                }
                else {
                    $ProjectFavorite->status = "active";
                    $ProjectFavorite->save();
                    return $this->message('Project has been favorited!');
                }
            }
            ProjectFavorite::updateOrCreate([
                'user_id' =>  Auth()->user()->id,
                'project_id' =>  $model->id,
                'status' =>  "active"
            ]);
            return $this->message('Project has been favorited!');
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
