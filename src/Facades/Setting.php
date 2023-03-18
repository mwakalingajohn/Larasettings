<?php

namespace MwakalingaJohn\LaraSettings\Facades;

use MwakalingaJohn\LaraSettings\Registrar\SettingRegistrar;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection|\MwakalingaJohn\LaraSettings\Eloquent\Setting[] getSettings()
 * @method static \MwakalingaJohn\LaraSettings\Registrar\Declaration name(string $name)
 */
class Setting extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return SettingRegistrar::class;
    }
}