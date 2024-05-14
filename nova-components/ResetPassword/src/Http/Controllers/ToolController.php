<?php

namespace Ugduck\ResetPassword\Http\Controllers;

use Illuminate\Http\Request as Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ToolController extends Controller
{
    public function index()
    {
        return response()->json([
            [
                "component" => "password-field",
                "prefixComponent" => true,
                "indexName" => __("Current Password"),
                "name" => __("Current Password"),
                "attribute" => "current_password",
                "value" => null,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ],
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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //  regex:/^([0-9\s\-\+\(\)]*)$/|min:8
        // Set Validator with Rules            
        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => [
                'required',
                'min:8',
                'confirmed',
                Password::min(8)->symbols(1)->numbers(1)
            ],
            'password_confirmation' => ['required'],
        ]);

        // Validate
        if ($validator->fails()) return response()->json(["message" => __(implode("<br>", $validator->errors()->all()))], 422);
        // Check Current Password            
        if (!Hash::check($request->input('current_password'), Auth::user()->password)) return response()->json(["message" => __('Current password was incorrect.')], 422);
        // Update Password            
        Auth::user()->password = Hash::make($request->input('password'));
        Auth::user()->save();
        // Success Message
        return response()->json(["message" => __("Your password has been updated!")]);
    }
}
