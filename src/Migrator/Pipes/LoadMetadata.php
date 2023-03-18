<?php

namespace MwakalingaJohn\LaraSettings\Migrator\Pipes;

use Closure;
use MwakalingaJohn\LaraSettings\Eloquent\Metadata;
use MwakalingaJohn\LaraSettings\Migrator\Data;

/**
 * @internal
 */
class LoadMetadata
{
    /**
     * Handles the Settings migration.
     *
     * @param  \MwakalingaJohn\LaraSettings\Migrator\Data  $data
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Data $data, Closure $next): mixed
    {
        $data->metadata = Metadata::all()->keyBy(static fn(Metadata $metadata): string => $metadata->name);

        return $next($data);
    }
}