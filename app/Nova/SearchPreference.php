<?php

namespace App\Nova;

use Alvinhu\ChildSelect\ChildSelect;
use App\Models\Category;
use App\Models\Location;
use App\Nova\Traits\PagePerOptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use NovaAjaxSelect\AjaxSelect;

class SearchPreference extends Resource
{
    use PagePerOptionTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SearchPreference::class;

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

    public function title()
    {
        return '';
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'city', 'state', 'county'
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
            BelongsTo::make('Vendor Name', 'user', '\App\Nova\Vendor')
                ->withMeta(['extraAttributes' => [
                    'readonly' => true,
                ]])
                ->display(function($user) {
                    return $user->fullDetails;
                })
                ->onlyOnIndex()
                ->canSee(function () {
                    return Auth::user()->hasRole(['superadmin', 'admin']);
                }),
            Select::make('Category', 'category_id')
                ->options(function () {
                    return array_filter(Category::pluck('name', 'id')->toArray());
                })
                ->displayUsingLabels()
                ->sortable()
                ->rules('required'),
            Select::make('State')
                ->sortable()
                ->options(function () {
                    return array_filter(Location::getStates());
                })
                ->rules('required')
                ->withMeta(['placeholder' => 'Select a State']),
            AjaxSelect::make('County')
                ->get('/nova-api/state/{state}/county')
                ->parent('state')
                ->rules('required')
            ,
            Select::make('County')->exceptOnForms(),
            Hidden::make("user_id")->default(function () {
                    return Auth::user()->id;
                })
                ->canSee(function ($request) {
                    return Auth::user()->hasRole('vendor');
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
/*
    public function authorizedToView(Model $model)
    {
        if(Auth::user()->hasRole('vendor')) {
            if($model->user_id == Auth::user()->id) return true;
        }
        return false;
    }
*/

    /**
     * Authorize to Create
     *
     * @return true if role is matched
     */
    public static function authorizedToCreate(Request $request)
    {
        return (Auth::user()->hasPermissionTo('searchPreferences.create')) ? true : false;
    }

    /**
     * Authorize to Delete
     *
     * @return true if role is matched
     */
    public function authorizedToDelete(Request $request)
    {
        return (Auth::user()->hasPermissionTo('searchPreferences.delete')) ? true : false;
    }

    /**
     * Authorize to Update
     *
     * @return true if role is matched
     */
    public function authorizedToUpdate(Request $request)
    {

        return (Auth::user()->hasPermissionTo('searchPreferences.update')) ? true : false;
    }

}
