<?php

namespace MwakalingaJohn\LaraSettings\Console\Commands;

use MwakalingaJohn\LaraSettings\Migrator\Data;
use MwakalingaJohn\LaraSettings\Migrator\Migrator;
use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @internal
 */
class MigrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:migrate
                            {--refresh : Wipes clean the settings table and metadata table.}
                            {--flush-cache : Flushes the cache used by LaraSettings, if enabled.}
                            {--force : Skips confirmation prompt on production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes and updates the settings from the database';

    /**
     * MigrateCommand constructor.
     *
     * @param  \MwakalingaJohn\LaraSettings\Migrator\Migrator  $migrator
     * @param  \MwakalingaJohn\LaraSettings\Migrator\Data  $data
     */
    public function __construct(protected Migrator $migrator, protected Data $data)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        // We will use the Input interface to use the same instance.
        $this->getLaravel()->instance(InputInterface::class, $this->input);
        $this->getLaravel()->instance(OutputStyle::class, $this->output);

        try {
            $this->migrator->send($this->data)->thenReturn();
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());
            return 1;
        }

        return 0;
    }
}
