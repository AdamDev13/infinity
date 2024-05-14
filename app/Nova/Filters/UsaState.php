<?php

namespace App\Nova\Filters;

use App\Models\Location;
use AwesomeNova\Filters\DependentFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UsaState extends DependentFilter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';
    
    public $name = 'Choose State';

    public $attribute = 'usastate';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if (empty($value)) {
            return $query;
        }

        $county = '';
        $filters = json_decode(base64_decode($request->get('filters', '{}')));
        foreach ($filters as $filter) {
            if ($filter->class === 'county') {
                $county = $filter->value;
            }
        }

        $uri = $request->path();
        if ($uri =="nova-api/clients") {
            if (empty($county)) {
                return $query->where('state', $value);
            } else {
                return $query->where('state', $value)->where('county', $county);
            }
        } elseif ($uri =="nova-api/projects") {
            if (empty($county)) {
                return $query->select('projects.*', 'users.id as uid', 'users.state')
                    ->join('users', 'projects.user_id', 'users.id')
                    ->where('users.state', $value);
            } else {
                return $query->select('projects.*', 'users.id as uid', 'users.state')
                    ->join('users', 'projects.user_id', 'users.id')
                    ->where('users.state', $value)
                    ->where('users.county', $county);
            }
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request, array $filters = [])
    {
        $states = array_flip(Location::getStates());
        $result = [];
        foreach ($states as $state => $value) {
            $result[] = [
                'name' => $state,
                'value' => $value,
            ];
        }
        return $result;
    }

    public function default()
    {
        return [

        ];
    }

}
