<?php

declare(strict_types=1);

namespace App\Traits;

use Filament\Notifications\Notification;

trait RequiresPhoneNumber
{
    public string $providingPhoneNumber;

    public bool $isProvidingPhoneNumber = false;

    public function startRequirePhoneNumber(): bool
    {
        if (! \Auth::check()) {
            Notification::make()
                ->warning()
                ->title('Yêu cầu đăng nhập')
                ->body('Vui lòng đăng nhập để sử dụng tính năng này.')
                ->send()
            ;

            return false;
        }

        // @phpstan-ignore-next-line
        $this->isProvidingPhoneNumber = ! \Auth::user()->phone_number;

        return ! $this->isProvidingPhoneNumber;
    }

    public function providePhoneNumber(string $gRecaptchaResponse): bool
    {
        if (! \Auth::check()) {
            Notification::make()
                ->warning()
                ->title('Yêu cầu đăng nhập')
                ->body('Vui lòng đăng nhập để sử dụng tính năng này.')
                ->send()
            ;

            return false;
        }

        if (
            ! \GoogleReCaptchaV3::setAction('provide_phone_number')
                ->verifyResponse($gRecaptchaResponse, \Request::ip())
                ->isSuccess()
        ) {
            Notification::make()
                ->warning()
                ->title('Captcha không hợp lệ')
                ->body('Vui lòng thử lại.')
                ->send()
            ;

            return false;
        }

        $this->validate([
            'providingPhoneNumber' => ['required', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})$/'],
        ]);

        \Auth::user()->update([
            'phone_number' => $this->providingPhoneNumber,
        ]);

        $this->stopRequirePhoneNumber();

        return true;
    }

    public function stopRequirePhoneNumber(): void
    {
        $this->isProvidingPhoneNumber = false;
    }

    public function ensurePhoneNumberIsProvided(): void
    {
        // @phpstan-ignore-next-line
        if (! \Auth::user()->phone_number) {
            abort(403, 'You must provide a phone number to continue.');
        }
    }
}
