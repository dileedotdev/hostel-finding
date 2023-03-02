<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();
        $email = $googleUser->getEmail();

        /** @var ?User */
        $user = User::whereGoogleId($googleUser->getId())->first() ?? $email
            ? User::whereEmail($googleUser->getEmail())->first()
            : null;

        if (! $user) {
            /** @var User */
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'profile_photo_path' => $googleUser->getAvatar(),
            ]);
        }

        auth()->login($user, true);

        return redirect()->route('hostels.index');
    }
}
