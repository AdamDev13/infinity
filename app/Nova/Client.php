<?php

namespace App\Nova;

use App\Imports\ClientImport;
use Bissolli\NovaPhoneField\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;


use App\Nova\Traits\AddressTrait;
use App\Nova\Traits\PagePerOptionTrait;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;

class Client extends Resource
{

    use PagePerOptionTrait, AddressTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Client::class;
    public static $importer = ClientImport::class;

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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'crm_id', 'account_number', 'company_name', 'first_name', 'last_name', 'email', 'address', 'city', 'county'
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
            (new Panel('', [
                Text::make('CRM ID', 'crm_id')
                    ->rules('required', 'max:255')
                    ->sortable()
                    ->canSee(function() {
                        return Auth::user()->hasAnyPermission(['superadmin', 'admin']);
                    }),
                Text::make('Acccount#', 'account_number')
                    ->rules('required', 'max:255')
                    ->sortable()
                    ->canSee(function() {
                        return Auth::user()->hasAnyPermission(['superadmin', 'admin']);
                    }),

                Text::make('Email')
                    ->rules('required', 'email', 'max:100')
                    ->sortable()
                    ->creationRules('unique:users,email')
                    ->updateRules('unique:users,email,{{resourceId}}')
                    ->canSee(function ($request) {
                        return Auth::user()->hasRole('superadmin');
                    }),
                Text::make('Company Name', 'company_name')
                    ->rules('max:100')
                    ->sortable(),
                Text::make('Name', 'name')
                    ->sortable()
                    ->onlyOnIndex(),
                Text::make('First Name', 'first_name')
                    ->rules('max:100')
                    ->sortable()
                    ->hideFromIndex(),
                Text::make('Last Name', 'last_name')
                    ->rules('max:100')
                    ->sortable()
                    ->hideFromIndex(),
                PhoneNumber::make('Phone', 'phone_number')
                    ->rules('max:30')
                    ->sortable()
                    ->hideFromIndex()
                    ->withCustomFormats('+1 ### ### ####.#########')
                    ->onlyCustomFormats(),
                PhoneNumber::make('Fax Number', 'fax_number')
                    ->rules('max:30')
                    ->sortable()
                    ->hideFromIndex()
                    ->withCustomFormats('+1 ### ### ####.#########')
                    ->onlyCustomFormats(),
                ]
            ))->withToolbar(),

            (new Panel('Address Details', $this->addressFields())),
            HasMany::make('Projects', 'projects', 'App\Nova\Project'),
            Hidden::make('type')->default('client')
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
        return [
            new \Sparclex\NovaImportCard\NovaImportCard(\App\Nova\Client::class),

        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        if (strpos(url()->previous(), 'clients') !== false) {
            return [
                new Filters\UsaState,
            ];
        }
        else {
            return [];
        }

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
        return $query->where('type', 'client')->get();
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


}
