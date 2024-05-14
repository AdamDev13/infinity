<?php
namespace App\Nova\Traits;

use Alvinhu\ChildSelect\ChildSelect;
use App\Models\Location;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use NovaAjaxSelect\AjaxSelect;

trait AddressTrait {


    /**
     * Get the address fields
     */
    public function addressFields() {
        return [
            Place::make('Address')
                ->rules('required', 'max:255')
                ->hideFromIndex()
                ->countries(["US"])
                ->secondAddressLine("address_continued")
                ->city("city")
                ->postalCode("postal")
                ->state("state"),
            Text::make('Address Continued', 'address_continued')
                ->rules('max:255')
                ->hideFromIndex(),
            Select::make('State')
                ->sortable()
                ->options(function () {
                    return array_filter(Location::getStates());
                })
                ->rules('required'),
            AjaxSelect::make('County')
                ->get('/nova-api/state/{state}/county')
                ->parent('state')
                ->rules('required')
            ,
            Select::make('County')->exceptOnForms(),
            Text::make('City')
                ->sortable()
                ->rules('required', 'max:100'),
            Text::make('Postal')
                ->sortable()
                ->rules('required', 'max:16'),

        ];
    }

}
