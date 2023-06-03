<?php

declare(strict_types=1);

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Support\Components\ViewComponent;
use Illuminate\Foundation\Vite;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function (): void {
            Filament::registerTheme(
                app(Vite::class)('resources/css/filament.css'),
            );

            Filament::registerStyles([
                app(Vite::class)('resources/css/places-autocomplete-dropdown.css'),
            ]);

            Filament::registerScripts([
                app(Vite::class)('resources/js/filament-admin.js'),
            ], shouldBeLoadedBeforeCoreScripts: true);

            if ($this->app->environment('local')) {
                Filament::pushMeta([
                    new HtmlString('<meta name="referrer" content="no-referrer" />'),
                ]);
            }

            Filament::registerRenderHook(
                'body.end',
                fn (): string => \Blade::render(<<<'BLADE'
                        <div class="fixed bottom-3 right-3 z-10">
                            <livewire:chat />
                        </div>
                    BLADE)
            );
        });

        ViewComponent::macro('localizeLabel', function () {
            // @phpstan-ignore-next-line
            $this->label(function (?string $model = null, $column = null, ...$args): string {
                /** @phpstan-ignore-next-line */
                $name = $this->getName();
                $model = new \ReflectionClass($model ?? $column->getTable()->getModel());
                $modelName = \Str::lower($model->getShortName());
                $key = 'models.'.$modelName.'.'.$name;
                $trans = __($key);

                if ($trans === $key) {
                    $trans = \Str::of($name)
                        ->beforeLast('.')
                        ->afterLast('.')
                        ->kebab()
                        ->replace(['-', '_'], ' ')
                        ->toString()
                    ;

                    $trans = __($trans);
                }

                return ucfirst($trans);
            });

            return $this;
        });
    }
}
