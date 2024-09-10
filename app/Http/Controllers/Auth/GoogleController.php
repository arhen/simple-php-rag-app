<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Google_Client;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                # if user role is not user
                if ($finduser->role != 'user') {
                    return redirect()->intended('login')->with('error', 'You are not authorized to access this application.');
                }
                Auth::login($finduser);
                return redirect()->intended('upload');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy'),
                    'role' => 'user',
                ]);

                Auth::login($newUser);
                return redirect()->intended('upload');
            }
        } catch (\Exception $e) {
            return redirect('login')->with('error', 'Google login failed. Please try again.');
        }
    }

    public function handleGoogleLogin(Request $request)
    {
        $idToken = $request->input('id_token');

        $client = new Google_Client(['client_id' => config('services.google.client_id')]);
        $payload = $client->verifyIdToken($idToken);

        if ($payload) {
            $google_id = $payload['sub'];
            $email = $payload['email'];
            $name = $payload['name'];

            $user = User::where('google_id', $google_id)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'google_id' => $google_id,
                    'password' => encrypt('123456dummy'),
                    'role' => 'user',
                ]);
            }

            if ($user->role != 'user') {
                return response()->json(['error' => 'You are not authorized to access this application.'], 403);
            }

            Auth::login($user);

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Invalid token'], 400);
    }
}
