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

class ProjectFavorite extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ProjectFavorite::class;

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


    public static function label() {
        return 'Project Favorites';
    }

    public static function singularLabel()
    {
        return 'Project Favorite';
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
            DateTime::make('Favortied When', 'updated_at')
                ->format("lll")
                ->sortable(),
            BelongsTo::make('Project Name', 'project', '\App\Nova\Project')
                ->display(function($project) {
                    return $project->name;
                }),
            BelongsTo::make('Category', 'project', '\App\Nova\Project')
                ->display(function($project) {
                    $Category = Category::where("id", $project->category_id)->first();
                    return $Category->name;
                })
                ->viewable(false),
            BelongsTo::make('Project Due Date', 'project', '\App\Nova\Project')
                ->display(function($project) {
                    return $project->deadline_only_date;
                })
                ->viewable(false),
            Text::make(__('Vendor'), 'user->viewedBy')
            ->canSee(function ($request) {
                return !Auth::user()->hasRole('vendor');
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
        $whereClause = [];
        // if Vendor > only return Vendor Project Views
        if(Auth::user()->hasRole(['vendor', 'admin'])) {
            $whereClause[] = ['project_favorites.user_id', '=', Auth::user()->id];
        }

        return $query
            ->where($whereClause)
            ->whereNotNull('projects.id')
            ->leftJoin('projects', 'project_favorites.project_id', '=', 'projects.id')
            ->get();
    }

    /**
     * Authorize to View
     *
     * @return bool true if role is matched
     */
    public function authorizedToView(Request $request)
    {
        return false;
    }

    /**
     * Authorize to Create
     *
     * @return bool true if role is matched
     */
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Authorize to Delete
     *
     * @return bool true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    /**
     * Authorize to Update
     *
     * @return bool true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

}