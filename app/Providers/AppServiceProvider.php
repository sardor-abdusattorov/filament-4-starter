<?php

namespace App\Providers;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\Settings;
use App\Models\SiteSettings;
use App\Models\SiteTranslation;
use App\Observers\SettingsObserver;
use App\Observers\SiteSettingsObserver;
use App\Observers\SiteTranslationObserver;
use App\Policies\ActivityPolicy;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    protected array $policies = [
        Activity::class => ActivityPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configurePolicies();

        $this->configureDB();

        $this->configureModels();

        $this->configureFilament();

        $this->configureLimit();

        $this->configureObservers();

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ru', 'uz', 'en'])
                ->labels([
                    'ru' => __('app.label.ru'),
                    'uz' => __('app.label.uz'),
                    'en' => __('app.label.en'),
                ]);
        });

        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component
                ->localesLabels([
                    'ru' => __('app.label.ru'),
                    'uz' => __('app.label.uz'),
                    'en' => __('app.label.en'),
                ])
                ->locales(['uz', 'ru', 'en'])
                ->addDirectionByLocale()
                ->addEmptyBadgeWhenAllFieldsAreEmpty(emptyLabel: __('app.label.empty'))
                ->addSetActiveTabThatHasValue();
        });
    }

    private function configurePolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    private function configureDB(): void
    {
        DB::prohibitDestructiveCommands($this->app->environment('production'));
    }

    private function configureModels(): void
    {
        Model::preventAccessingMissingAttributes();

        Model::unguard();
    }

    private function configureFilament(): void
    {
        FilamentShield::prohibitDestructiveCommands($this->app->isProduction());

        Column::configureUsing(fn (Column $column) => $column->toggleable());

        Table::configureUsing(fn (Table $table) => $table
            ->reorderableColumns()
            ->deferColumnManager(false)
            ->deferFilters(false)
            ->paginationPageOptions([10, 25, 50])
        );
    }

    private function configureLimit(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
    }

    private function configureObservers(): void
    {
        Settings::observe(SettingsObserver::class);
        SiteSettings::observe(SiteSettingsObserver::class);
        SiteTranslation::observe(SiteTranslationObserver::class);
    }
}
