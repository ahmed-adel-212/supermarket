<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\NotificationToken;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends AbstractApiController
{
    public function login(LoginRequest $request)
    {
        // $request->validate([
        //     'email' => 'required|email|exists:users,email',
        //     'password' => 'required|string|max:2',
        // ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->isCustomer()) {
                $data = [
                    'userData' => $user,
                     'token' => $user->createToken('AppName')->accessToken,
                   // 'token' => $user->token,
                ];
                
                if ($request->has('device_token')) {
                    NotificationToken::create(['user_id'=>$user->id,'token'=>$request->device_token]);
                }
                \App\Http\Controllers\NotificationController::sendNotification($user->id, "New Order has been placed", "Order");
                return $this->sendResponse($data, __('auth.logged'));
            }
        }

        return $this->sendError(__('auth.unauthorised!'), $credentials, 401);
    }

    public function cashierLogin(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->isCashier()) {
                $data = [
                    'userData' => $user,
                    'token' => $user->token,
                ];

                return $this->sendResponse($data, __('auth.logged'));
            }
        }

        return $this->sendError(__('auth.unauthorised!'), $credentials, 401);
    }

    public function register(Request $request)
    {
        $req = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['required', 'string', 'size:12', 'unique:users,phone']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            // 'type' => 'customer', // default
            // no verification required
            'email_verified_at' => now(),
        ]);

        $user->token = $user->createToken('appName')->accessToken;
        $user->save();

        return $this->sendResponse([
            'user' => $user->fresh(),
        ], __('general.created', ['key' => __('auth.user_account')]));
    }
}
