<?php

namespace App\Nova;

use App\Nova\Traits\AddressTrait;
use App\Nova\Traits\PagePerOptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;

class Vendor extends Resource
{

    use PagePerOptionTrait, AddressTrait;
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Vendor::class;
    
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
        return [
            (new Panel('Vendor Details', [
                Text::make('Company Name', 'company_name')
                    ->sortable()
                    ->rules('required', 'max:255'),
                Text::make('Email')
                    ->sortable()
                    ->rules('required', 'email', 'max:254')
                    ->creationRules('unique:users,email')
                    ->updateRules('unique:users,email,{{resourceId}}')
                    ->canSee(function ($request) {
                        return Auth::user()->hasRole(['superadmin', 'admin']);
                    }),
                Text::make('Name', 'name')
                    ->rules('required', 'max:255')
                    ->onlyOnIndex(),
                Text::make('First Name', 'first_name')
                    ->sortable()
                    ->rules('required', 'max:100')
                    ->hideFromIndex(),
                Text::make('Last Name', 'last_name')
                    ->sortable()
                    ->rules('required', 'max:100')
                    ->hideFromIndex(),
                Text::make('Phone', 'phone_number')
                    ->sortable()
                    ->rules('required', 'max:30')
                    ->hideFromIndex(),
                Text::make('Fax Number', 'fax_number')
                    ->sortable()
                    ->rules('max:30')
                    ->hideFromIndex(),
                Hidden::make('type')->default('vendor'),
            ]
        ))->withToolbar(),

        (new Panel('Address Details', $this->addressFields())),

            HasMany::make('Search Preferences', 'searchPreferences', 'App\Nova\SearchPreference')->canSee(function ($request) {
                return Auth::user()->hasRole('vendor');
            }),
            HasMany::make('Project Views', 'projectViews', 'App\Nova\ProjectView'),

            HasMany::make('Project Favorites', 'projectFavorites', 'App\Nova\ProjectFavorite'),

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
        return $query->where('type', 'vendor')->get();
    }


    /**
     * Authorize to Create
     * 
     * @return true if role is matched
     */
    public static function authorizedToCreate(Request $request)
    {
        return (Auth::user()->hasPermissionTo("vendor.create")) ? true : false;
    }

    /**
     * Authorize to Delete
     * 
     * @return true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return (Auth::user()->hasPermissionTo("vendor.delete")) ? true : false;
    }

    /**
     * Authorize to Update
     * 
     * @return true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {
        return (Auth::user()->hasPermissionTo("vendor.view")) ? true : false;
    }

}
