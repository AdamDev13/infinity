<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class UpdateProjectEmails extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UpdateProjectEmail::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $query = $request->query();
        $project = isset($query['viaResourceId']) ? \App\Models\Project::with('category')->find($query['viaResourceId']) : null;
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Textarea::make('Email Title')
                ->rules('required')
                ->rows(1)
                ->default(function () use($project) {
                    return $project ? Str::title($project->name) . ' Details Have Been Updated.' : 'Project Updated';
                })
                ->sortable(),

            Markdown::make('Email Content')
                ->rules('required')
                ->default(function () use($project) {
                    return view('emails.update-project', [
                        'projectName' => $project ? $project->name : '',
                        'clientName' => ($project && $project->user) ? $project->user->company_name : '',
                        'category' => ($project && $project->category) ? $project->category->name : '',
                        'todayDate' => date("m-d-Y"),
                        'viewLink' => $project ? env('APP_URL') . 'users/resources/projects/' . $project->id : '',
                    ])->render();
                })
                ->sortable(),

            BelongsTo::make('Project Name', 'project', '\App\Nova\Project')
                ->default(isset($query['viaResourceId']) ? $query['viaResourceId'] : 0)
                ->display(function($project) {
                    return $project->name;
                })
                ->hideWhenCreating()
                ->readonly(false),

            Text::make('Due Date')
                ->default(date("Y-m-d"))
                ->rules('required')
                ->hideWhenCreating()
                ->readonly(true)
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
     * Get the text for the update resource button.
     *
     * @return string|null
    */
    public static function createButtonLabel()
    {
        return 'Send Update Email';
    }
}
