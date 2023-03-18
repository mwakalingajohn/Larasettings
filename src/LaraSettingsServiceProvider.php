<?php

namespace MwakalingaJohn\LaraSettings;

use MwakalingaJohn\LaraSettings\Registrar\SettingRegistrar;
use Generator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * @internal
 */
class LaraSettingsServiceProvider extends ServiceProvider
{
    /**
     * The migration files.
     *
     * @var array|string[]
     */
    protected const MIGRATION_FILES = [
        __DIR__ . '/../database/migrations/00_00_00_000000_create_user_settings_table.php',
        __DIR__ . '/../database/migrations/00_00_00_000000_create_user_settings_metadata_table.php',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/larasettings.php', 'larasettings');

        $this->app->singleton(SettingRegistrar::class, static function($app): SettingRegistrar {
            return new SettingRegistrar(
                $app['config'],
                new Collection(),
                new Collection(),
                $app[Filesystem::class],
                $app
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\MigrateCommand::class,
                Console\Commands\PublishCommand::class,
                Console\Commands\CleanCommand::class,
            ]);

            $this->publishes([__DIR__.'/../config/larasettings.php' => config_path('larasettings.php')], 'config');

            $this->publishes(iterator_to_array($this->migrationPathNames()), 'migrations');
        }
    }

    /**
     * Returns the migration file destination path name.
     *
     * @return \Generator
     */
    protected function migrationPathNames(): Generator
    {
        foreach (static::MIGRATION_FILES as $file) {
            yield $file => $this->app->databasePath(
                'migrations/' . now()->format('Y_m_d_His') . Str::after($file, '00_00_00_000000')
            );
        }
    }
}
