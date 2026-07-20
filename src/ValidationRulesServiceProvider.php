<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules;

use Illuminate\Support\ServiceProvider;

final class ValidationRulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(
            __DIR__.'/../resources/lang',
            'validation-rules',
        );

        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/validation-rules'),
        ], 'validation-rules-translations');
    }
}
