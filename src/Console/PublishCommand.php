<?php

namespace Webkinder\Sailrock\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'sailrock:publish')]
class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sailrock:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the Sailrock Docker files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'sailrock-docker']);
        $this->call('vendor:publish', ['--tag' => 'sailrock-database']);

        file_put_contents(
            $this->laravel->basePath('docker-compose.yml'),
            str_replace(
                [
                    './vendor/webkinder/sailrock/runtimes/8.4',
                    './vendor/webkinder/sailrock/runtimes/8.3',
                    './vendor/webkinder/sailrock/runtimes/8.2',
                    './vendor/webkinder/sailrock/runtimes/8.1',
                    './vendor/webkinder/sailrock/runtimes/8.0',
                    './vendor/webkinder/sailrock/database/mysql',
                    './vendor/webkinder/sailrock/database/pgsql'
                ],
                [
                    './docker/8.4',
                    './docker/8.3',
                    './docker/8.2',
                    './docker/8.1',
                    './docker/8.0',
                    './docker/mysql',
                    './docker/pgsql'
                ],
                file_get_contents($this->laravel->basePath('docker-compose.yml'))
            )
        );
    }
}
