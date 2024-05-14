<?php

namespace App\Nova\Filters;

use App\Models\Location;
use AwesomeNova\Filters\DependentFilter;
use Illuminate\Http\Request;


class County extends DependentFilter
{
    public $dependentOf = ['usastate'];

    function options(Request $request, $filters = [])
    {
        $result = [];
        if (!empty($filters['usastate'])) {
            $state = $filters['usastate'];
            $countries = Location::getCounties($state);
            foreach ($countries as $name => $value) {
                $result[] = [
                    'name' => $name,
                    'value' => $value,
                ];
            }
        }
        return $result;
    }
}
