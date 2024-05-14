<?php

namespace App\Nova;

use App\Nova\Traits\PagePerOptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Dropzone;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Illuminate\Support\Str;

class ProjectAddendum extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProjectAddendum::class;

    /**
     * Display resource in navigation.
     *
     * @var boolean
     */
    public static $displayInNavigation = false;
    public static $pagination = false;


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
    public static $title = 'label';

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

    public static function label()
    {
        return 'Project Addendums';
    }

    public static function singularLabel()
    {
        return 'Project Addendum';
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
            // !IMPORTANT - cannot delete belongsTo or put in panel - will crash nested forms
            BelongsTo::make('Project', 'project', '\App\Nova\Project')
                ->withMeta(['extraAttributes' => [
                    'readonly' => false,
                ]])
                ->display(function($model) {
                    return $model->name;
                })
                ->hideFromIndex(),
            (new Panel('Addendum Files', [
                Text::make(__('Name of File'), 'label')
                    ->rules('required', 'max:255'),

                Dropzone::make(__('Url'), 'url')
                    ->disk('s3')
                    ->path('Addendum')
                    ->delete(function (Request $request, $model, $disk, $path) {
                        if (! $path) {
                            return;
                        }

                        Storage::disk($disk)->delete($path);

                        return [
                            'url' => null
                        ];
                    })
                    ->creationRules('required')
                    ->onlyOnForms(),

                Text::make(__('Click any file to download'), function($model) {
                    return '<a href="' . $model->url . '" style="font-size:16px; text-decoration: none;" target="_blank"><img style="position:relative; top:2px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAABmJLR0QA/wD/AP+gvaeTAAAA8ElEQVQ4jc3TLU4DQRjG8R8UECiOUcGGSpriIOEACD4SHMGh4AAcoaaWBNUKDCeAAyAIIHoLFBCShSB2l0ynDTtLEDxq8uZ5/jPvvDP8keYa+nvYiGrXGC80BL3guVyv4gQfGDfkfKuNB/RxBuGJDrGNpRnBdxzjDRmG2MM6VkLQFg5wjnwGKI8g+3gqQRM6xVFNO1kZzoJaB93wRHXTyzBStPOIZbzivjLM1wAophNCOhjEppTxt7GraKvKTOVSQFcJnqTWkvR/QTlaiZmW4n9NqLrsW1yU4ClTpB1cxsXwIa5hE4s/QD5xh5uazX6vL5j+Jo2wFztXAAAAAElFTkSuQmCC"/> Download File</a>';
                    })
                    ->help("Must include http or https")
                    ->rules('required', 'max:255')
                    ->asHtml(),
            ])),
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
        return (Auth::user()->hasRole(["superadmin","admin"])) ? true : false;
    }

    /**
     * Authorize to Delete
     *
     * @return true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return (Auth::user()->hasRole(["superadmin","admin"])) ? true : false;
    }

    /**
     * Authorize to Update
     *
     * @return true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {
        return (Auth::user()->hasRole(["superadmin","admin"])) ? true : false;
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        if ((Auth::user()->hasRole(["superadmin","admin"]))){
            return '/resources/projects/'.$resource->project_id.'/edit';
        }
        return parent::redirectAfterCreate($request, $resource);
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        if ((Auth::user()->hasRole(["superadmin","admin"]))){
            return '/resources/projects/'.$resource->project_id.'/edit';
        }
        return parent::redirectAfterCreate($request, $resource);
    }
}
