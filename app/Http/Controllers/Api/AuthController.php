<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);


        $request['password'] = Hash::make($request->password);
        $request['type'] = 'vendor';
        $user = User::create($request->all());

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if (!\Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages(['message' => 'Invalid login details']);
        }

        $user = User::role('vendor')->where('email', $request['email'])->first();

        if (!$user) {
            \Auth::guard('web')->logout();
            throw ValidationException::withMessages(['message' => 'Access Denied']);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        \Auth::guard('web')->logout();
        return response()->json([
            'isLogout' => true
        ], 200);
    }

    public function getProfile()
    {
        $user = Auth::user();
        $data = [
            'user' => $user,
            'states' => Location::getStates(),
            'country' => Location::getCounties($user->state),
        ];
        return response()->json($data);
    }

    public function getStates(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Location::getStates());
    }

    public function updateProfile(Request $request)
    {
        $user=Auth::user();
        $this->validate($request,[
            'email' => 'required|email|unique:users,email,'.$user->id
        ]);

        $user->update($request->all());
        $data = [
            'user' => Auth::user(),
            'message' => 'Profile updated successfully'
        ];
        return response()->json($data);
    }

    public function ProfileResetPassword(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'current_password' => ['required',function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => 'required|min:8',
        ]);

        $data['password'] = Hash::make($request['password']);
        $user->update($data);
        return response()->json(['message' => 'Your Password Updated Successfully','reset_password' => true]);
    }

    public function forgotPassword(Request $request)
    {
        $this->validate($request,['email' => 'required|email|exits:users']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT ? back()->with(['status' => __($status)]): back()->withErrors(['email' => __($status)]);
    }

    public function sendPasswordResetLink(Request $request)
    {
        $this->validate($request,['email' => 'required|email|exists:users']);

        return $this->sendResetLinkEmail($request);
    }

    protected function sendResetLinkResponse(Request $request, $response): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Password reset email sent.',
            'data' => $response
        ]);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response): \Illuminate\Http\JsonResponse
    {
        throw ValidationException::withMessages(['message' => 'Email could not be sent to this email address.']);
//        return response()->json(['message' => 'Email could not be sent to this email address.']);
    }

    public function callResetPassword(Request $request)
    {
        return $this->reset($request);
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response): \Illuminate\Http\JsonResponse
    {
        return response()->json(['message' => 'Password reset successfully.']);
    }

    protected function sendResetFailedResponse(Request $request, $response): \Illuminate\Http\JsonResponse
    {
        throw ValidationException::withMessages(['message' => 'Failed, Invalid Token.']);
//        return response()->json(['message' => 'Failed, Invalid Token.']);
    }









}
