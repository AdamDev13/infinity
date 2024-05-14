<?php

namespace App\Nova\Actions;

use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Hidden;

class DetachedFavoriteProject extends DetachedAction
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $name ="ok";
    public $withoutConfirmation = true;

    public $project_id;
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * Get the displayable label of the button.
     *
     * @return string
     */
    public function label()
    {
        return __('❤ Favorite');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields, ?Collection $resources = null)
    {
        if (isset(request()->resourceId)) {
        //    Model::find(request()->resourceId)->first()
    }
    return DetachedAction::message('It worked!' . request()->resourceId );
        return DetachedAction::message('It worked!' . implode(", ", array_keys($fields)) );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Hidden::make("project_id")
                ->default($this->project_id)
        ];
    }
}
