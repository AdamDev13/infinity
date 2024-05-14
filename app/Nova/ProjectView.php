<?php

namespace App\Nova;

use App\Models\Category;
use App\Nova\Traits\PagePerOptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaButton\Button;

class ProjectView extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProjectView::class;

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
    public static $title = 'id';

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
        return 'Project Views';
    }

    public static function singularLabel()
    {
        return 'Project View';
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
            BelongsTo::make('Project Name', 'project', '\App\Nova\Project')
                ->display(function($project) {
                    return $project->name;
                })
                ->canSee(function ($request) {
                    return Auth::user()->hasRole('vendor');
                }),
            BelongsTo::make('Category', 'project', '\App\Nova\Project')
                ->display(function($project) {
                    $Category = Category::where("id", $project->category_id)->first();
                    return $Category->name;
                })
                ->viewable(false)
                ->canSee(function ($request) {
                    return Auth::user()->hasRole('vendor');
                }),
            Text::make(__('Company Name'), 'user->company_name')
                ->canSee(function ($request) {
                    return !Auth::user()->hasRole('vendor');
                }),
            Text::make(__('Name'), 'user->name')
                ->canSee(function ($request) {
                    return !Auth::user()->hasRole('vendor');
                }),
            Text::make(__('Email'), 'user->email')
                ->canSee(function ($request) {
                    return !Auth::user()->hasRole('vendor');
                }),
            DateTime::make('Viewed When', 'viewed_at')
                ->format("lll")
                ->sortable(),
//            Button::make('Text')->link(env('APP_URL') . 'users/resources/vendors/' . $this->user_id)
            Button::make('View Vendor')
                ->detail('App\Nova\Vendor', $this->user_id)
                ->canSee(function ($request) {
                    return Auth::user()->hasPermissionTo('admin');
                })

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
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        // if Vendor > only return Vendor Project Views
        if(Auth::user()->hasRole('vendor')) return $query->where('user_id', Auth::user()->id)->get();
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
