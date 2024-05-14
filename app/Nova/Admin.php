<?php

namespace App\Nova;

use App\Nova\Traits\PagePerOptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Admin extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Admin::class;

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
    public static $title = 'name';

    /**
     * The order in which the resources will be displayed.
     *
     * @var int
     */
    public static $priority = 10;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name', 'last_name', 'email'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            (new Panel('Admin Details', [
                Text::make('Name', 'name')->sortable()
                    ->onlyOnIndex(),
                Text::make('First Name', 'first_name')
                    ->hideFromIndex()
                    ->rules('required', 'max:255'),
                Text::make('Last Name', 'last_name')
                    ->hideFromIndex()
                    ->rules('required', 'max:255'),
                Text::make('Email', 'email')
                    ->sortable()
                    ->rules('required', 'email', 'max:255'),
                Hidden::make('type')->default('admin')
            ]))->withToolbar()
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
        return $query->where('type', 'admin')->get();
    }

    /**
     * Authorize to View
     *
     * @return true if role is matched
     */
    public function authorizedToView(Request $request)
    {
        return true;
    }

    /**
     * Authorize to Create
     *
     * @return true if role is matched
     */
    public static function authorizedToCreate(Request $request)
    {
        return (Auth::user()->hasRole(["superadmin"])) ? true : false;
    }

    /**
     * Authorize to Delete
     *
     * @return true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return true;
    }

    /**
     * Authorize to Update
     *
     * @return true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {
        return true;
    }

}
