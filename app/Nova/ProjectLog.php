<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

use App\Nova\Traits\PagePerOptionTrait;
class ProjectLog extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProjectLog::class;
    
    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $displayInNavigation = false;
    

    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $tableStyle = 'default';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'projectBelongs.name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    public static function searchable()
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Project #', 'projectBelongs', '\App\Nova\Project')
                ->withMeta(['extraAttributes' => [
                    'readonly' => false,
                ]])
                ->display(function($project) {
                    return $project->project_number;
                })
                ->viewable(false),
            BelongsTo::make('Project Name', 'projectBelongs', '\App\Nova\Project')
                ->withMeta(['extraAttributes' => [
                    'readonly' => false,
                ]])
                ->display(function($project) {
                    return $project->name;
                })
                ->viewable(false),
            Text::make('Event'),
            DateTime::make('Date', 'created_at')
                ->format("lll")
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Authorize to Create
     * 
     * @return true if role is matched
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Authorize to Delete
     * 
     * @return true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Authorize to Update
     * 
     * @return true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

}
