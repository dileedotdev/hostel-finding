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
            $user = User::forceCreate([
                'name' => $googleUser->getName(),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'profile_photo_path' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        } else {
            $user
                ->forceFill([
                    'google_id' => $googleUser->getId(),
                    'profile_photo_path' => $googleUser->getAvatar(),
                ])
                ->save()
            ;
        }

        auth()->login($user, true);

        return redirect()->route('hostels.index');
    }

    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(): RedirectResponse
    {
        $facebookUser = Socialite::driver('facebook')->user();
        $email = $facebookUser->getEmail();

        /** @var ?User */
        $user = User::whereFacebookId($facebookUser->getId())->first() ?? $email
            ? User::whereEmail($facebookUser->getEmail())->first()
            : null;

        if (! $user) {
            /** @var User */
            $user = User::forceCreate([
                'name' => $facebookUser->getName(),
                'email' => $email,
                'facebook_id' => $facebookUser->getId(),
                'profile_photo_path' => $facebookUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        } else {
            $user
                ->forceFill([
                    'facebook_id' => $facebookUser->getId(),
                    'profile_photo_path' => $facebookUser->getAvatar(),
                ])
                ->save()
            ;
        }

        auth()->login($user, true);

        return redirect()->route('hostels.index');
    }
}
