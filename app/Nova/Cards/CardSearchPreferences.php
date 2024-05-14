<?php

namespace App\Nova\Cards;

use App\Models\Location;
use App\Models\SearchPreference;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;
use Mako\CustomTableCard\Table\Cell;
use Mako\CustomTableCard\Table\Row;

class CardSearchPreferences extends \Mako\CustomTableCard\CustomTableCard
{

    public $width = '1/2';

    public function __construct()
    {
        $header = collect(['Category', 'State', 'County']);

        $this->title('Search Preferences');
        $this->viewall(['label' => 'View All', 'link' => Nova::path() . '/resources/search-preferences']);

        $searchPreferences = SearchPreference::where("user_id", Auth::user()->id)->latest()->paginate(7);

        $this->header($header->map(function($value) {
            return new Cell($value);
        })->toArray());

        $states = Location::getStates();

        $data = $searchPreferences->map(function($model) use($states) {
            $url = [
                [
                    "class" => "usastate",
                    "value" => $model["state"],
                ],
                [
                    "class" => "county",
                    "value" => $model["county"],
                ],
                [
                    "class" => "App\\Nova\\Filters\\DueBy",
                    "value" => "",
                ]
            ];
            $row = new Row(
                new Cell(isset($model['category']) ? $model['category']["name"] : ''),
                new Cell($states[$model["state"]]),
                new Cell($model["county"]),
//                new Cell('<a href="">view</a>')
            );
//            return $row->viewLink(base64_decode($url));
//            return $row->viewLink('../resources/projects?projects_filter=' . trim(base64_encode($url)));
            return $row->viewLink('../resources/projects?projects_filter=' . trim(base64_encode(json_encode($url))));
        });

        $this->data($data->toArray());
    }

}


/*

$url= [["class" => "App\\\Nova\\\Filters\\\UsaState", "value" => "AK"]]; echo trim(base64_encode($url));

echo urldecode(base64_decode('W3siY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXFVzYVN0YXRlIiwidmFsdWUiOiJBSyJ9LHsiY2xhc3MiOiJBcHBcXE5vdmFcXEZpbHRlcnNcXER1ZUJ5IiwidmFsdWUiOiIifV0%3D'));

echo trim(base64_encode('
    [
        {"class":"App\\\Nova\\\Filters\\\UsaState","value":"AK"},
        {"class":"App\\\Nova\\\Filters\\\DueBy","value":""}
    ]
'));

*/
