<?php

namespace Ugduck\Myprofile\Http\Controllers;

use Alvinhu\ChildSelect\ChildSelect;
use App\Models\Location;
use Bissolli\NovaPhoneField\PhoneNumber;
use http\Env\Response;
use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class ToolController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            Text::make('Email')
                ->rules('required', 'email', 'max:100')
                ->sortable()
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}')
                ->withMeta(['value' => Auth::user()->email]),
            Text::make('Company Name', 'company_name')
                ->rules('max:100')
                ->sortable()
                ->hideFromIndex()
                ->withMeta(['value' => Auth::user()->company_name]),
            Text::make('First Name', 'first_name')
                ->rules('max:100')
                ->sortable()
                ->hideFromIndex()
                ->withMeta(['value' => Auth::user()->first_name]),
            Text::make('Last Name', 'last_name')
                ->rules('max:100')
                ->sortable()
                ->hideFromIndex()
                ->withMeta(['value' => Auth::user()->last_name]),
            PhoneNumber::make('Phone', 'phone_number')
                ->rules('max:30')
                ->sortable()
                ->hideFromIndex()
                ->withCustomFormats('+1 ### ### ####.#########')
                ->withMeta(['value' => Auth::user()->phone_number])
                ->onlyCustomFormats()
            ,
            PhoneNumber::make('Fax Number', 'fax_number')
                ->rules('max:30')
                ->sortable()
                ->hideFromIndex()
                ->withCustomFormats('+1 ### ### ####.#########')
                ->withMeta(['value' => Auth::user()->fax_number])
                ->onlyCustomFormats(),
            Text::make('Address', 'address')
                ->rules('max:255')
                ->sortable()
                ->hideFromIndex()
                ->withMeta(['value' => Auth::user()->address]),
            Text::make('Address Continued', 'address_continued')
                ->rules('max:255')
                ->sortable()
                ->hideFromIndex()
                ->withMeta(['value' => Auth::user()->address_continued]),
            Select::make('State')
                ->sortable()
                ->options(function () {
                    return array_filter(Location::getStates());
                })
                ->withMeta(['value' => Auth::user()->state])
                ->rules('required'),
//            Select::make('County')
//                ->sortable()
//                ->options($this->getCounties())
//                ->withMeta(['value' => Auth::user()->county])
//                ->rules('required'),
//            ChildSelect::make('Country','county')
//                ->parent('state')
//                ->options(function ($value) use ($user) {
//                    $value = $user->state;
//                    $counties = Location::getCounties($value);
//                    foreach($counties as $county_id => $county_name) {
//                        $return[$county_id] = $county_name;
//                    }
//                    return $return;
//                })
//                ->withMeta(['value' => Auth::user()->county])
//                ->rules('required'),
            Text::make('City','city')
                ->sortable()
                ->withMeta(['value' => Auth::user()->city])
                ->rules('required', 'max:100'),
            Text::make('Postal','postal')
                ->sortable()
                ->withMeta(['value' => Auth::user()->postal])
                ->rules('required', 'max:16'),
        ]);
//        return response()->json([
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("E-mail Address"),
//                "name" => __("E-mail Address"),
//                "attribute" => "email",
//                "value" => auth()->user()->email,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//                "readonly" => true,
//                "required" => true,
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("Company Name"),
//                "name" => __("Company Name"),
//                "attribute" => "company_name",
//                "value" => auth()->user()->company_name,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//                "required" => true,
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("First Name"),
//                "name" => __("First Name"),
//                "attribute" => "first_name",
//                "value" => auth()->user()->first_name,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//                "required" => true,
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("Last Name"),
//                "name" => __("Last Name"),
//                "attribute" => "last_name",
//                "value" => auth()->user()->last_name,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//                "required" => true,
//            ],
//            [
//                "component" => "nova-phone-field",
//                "prefixComponent" => true,
//                "indexName" => __("Phone Number"),
//                "name" => __("Phone Number"),
//                "attribute" => "phone_number",
//                "value" => auth()->user()->phone_number,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "nova-phone-field",
//                "prefixComponent" => true,
//                "indexName" => __("Fax Number"),
//                "name" => __("Fax Number"),
//                "attribute" => "fax_number",
//                "value" => auth()->user()->fax_number,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("Address"),
//                "name" => __("Address"),
//                "attribute" => "address",
//                "value" => auth()->user()->address,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("Address Continued"),
//                "name" => __("Address Continued"),
//                "attribute" => "address_continued",
//                "value" => auth()->user()->address_continued,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("City"),
//                "name" => __("City"),
//                "attribute" => "city",
//                "value" => auth()->user()->city,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "select-field",
//                "options" => $this->getStates(),
//                "prefixComponent" => true,
//                "indexName" => __("State"),
//                "name" => __("State"),
//                "attribute" => "state",
//                "value" => auth()->user()->state,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ],
//            [
//                "component" => "select-field",
//                "options" => $this->getCounties(),
//                "prefixComponent" => true,
//                "indexName" => __("County"),
//                "name" => __("County"),
//                "attribute" => "county",
//                "value" => auth()->user()->county,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//                "onchange" => true,
//            ],
//            [
//                "component" => "text-field",
//                "prefixComponent" => true,
//                "indexName" => __("Postal"),
//                "name" => __("Postal"),
//                "attribute" => "postal",
//                "value" => auth()->user()->postal,
//                "panel" => null,
//                "sortable" => false,
//                "textAlign" => "left",
//            ]
//        ]);
    }

    /**
     * @return Fields for password and password confirmation
     */
    public function password() {
        return response()->json([
            [
                "component" => "password-field",
                "prefixComponent" => true,
                "indexName" => __("Password"),
                "name" => __("Password"),
                "attribute" => "password",
                "value" => null,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ],
            [
                "component" => "password-field",
                "prefixComponent" => true,
                "indexName" => __("Password Confirmation"),
                "name" => __("Password Confirmation"),
                "attribute" => "password_confirmation",
                "value" => null,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ]
        ]);
    }

    public function getStates() {
        $locations = Location::getStates();
        foreach($locations as $state_id => $state_val) {
            $states[] = [
                "label" => $state_val,
                "value" => $state_id
            ];
//            $states[] = [$state_id => $state_id];
        }
        return $states;
    }

    public function getCounties() {
        $counties =[];
        if(Auth::user()->state) {
            $locations = Location::getCounties(Auth::user()->state);
            foreach($locations as $key => $val) {
                $counties[] = [
                    "label" => $val,
                    "value" => $key
                ];
                //            $states[] = [$state_id => $state_id];
            }
        }
        return $counties;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $Request)
    {
      $Validator = Validator::make($Request->all(), [
        'email' => 'required|email',
        'company_name' => 'required|string',
        'first_name' => 'required|string',
        'last_name' => 'required|string',
    ]);

//    $errorKeys = array_keys($Validator->errors()->toArray());

    if ($Validator->fails()) {
//        return response()->json($Validator->errors()->toArray(), 422);
        return response()->json(["message" => implode("<br>", $Validator->errors()->all())], 422);
    }
    else {
        Auth::user()->fill([
            'email' => $Request->input('email'),
            'company_name' => $Request->input('company_name'),
            'first_name' => $Request->input('first_name'),
            'last_name' => $Request->input('last_name'),
            'phone_number' => $Request->input('phone_number'),
            'address' => $Request->input('address'),
            'city' => $Request->input('city'),
            'state' => $Request->input('state'),
            'county' => $Request->input('county'),
            'postal' => $Request->input('postal'),
            'fax_number' => $Request->input('fax_number'),
            'address_continued' => $Request->input('address_continued'),
        ])->save();
    }
    return response()->json(__("Your profile has been updated!"));
    }
}
