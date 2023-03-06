<?php

declare(strict_types=1);

namespace App\Http\Livewire\Hostel;

use App\Models\Hostel;
use App\Traits\RequiresPhoneNumber;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Livewire\Component;

class SubscribeForNews extends Component
{
    use RequiresPhoneNumber;

    public Hostel $hostel;

    public function mount(Hostel $hostel): void
    {
        $this->hostel = $hostel;
    }

    public function subscribe(string $gRecaptchaResponse): void
    {
        if (! \Auth::check()) {
            Notification::make()
                ->warning()
                ->title('Yêu cầu đăng nhập')
                ->body('Vui lòng đăng nhập để nhận tin.')
                ->send()
            ;

            return;
        }

        if (
            ! \GoogleReCaptchaV3::setAction('livewire_hostel_subscribe_for_news')
                ->verifyResponse($gRecaptchaResponse, \Request::ip())
                ->isSuccess()
        ) {
            Notification::make()
                ->warning()
                ->title('Captcha không hợp lệ')
                ->body('Vui lòng thử lại.')
                ->send()
            ;

            return;
        }

        if (\Auth::user()->can('subscribe', [$this->hostel])) {
            $this->hostel->subscribers()->attach(\Auth::id());
        }

        $this->ensurePhoneNumberIsProvided();

        Notification::make()
            ->success()
            ->title('Đăng ký thành công')
            ->body('Chủ nhà sẽ sớm liên hệ với bạn.')
            ->send()
        ;
    }

    public function render(): View
    {
        return view('livewire.hostel.subscribe-for-news');
    }
}
