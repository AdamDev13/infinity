<?php

namespace App\Nova\Filters;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Filters\Filter;

class DueBy extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value == 1) {
            return;
        } elseif ($value == 5) {
            return $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(7));
        } elseif ($value == 10) {
            return $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(30));
        } elseif ($value == 15) {
            return $query->whereDate('deadline_date', '<=', Carbon::now()->addDays(60));
        } elseif ($value == 20) {
            return $query->whereDate('deadline_date', '<=', Carbon::now());
        } elseif ($value == 0) {
            return $query->whereDate('public_date', ">", Carbon::now());
        }
    }

    /**
     * Get the filter's available options.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function options(Request $request)
    {
        $data = [
            'All Projects' => 1,
            'Less than 7 days' => 5,
            'Less than 30 days' => 10,
            'Less than 60 days' => 15,
            'Expired' => 20,
        ];
        if (Auth::user()->hasRole(['admin','superadmin'])) {
            $data['scheduled'] = 0;
        }
        return $data;
    }
}
