<?php


namespace App\Console\Commands\Deployment;

use Illuminate\Console\Command;

class HerokuPostDeploy extends Command
{
    protected $signature = 'postdeploy:heroku
                                   {--refresh : refresh database migrations.}';

    protected $description = 'Run post-deploy on heroku';

    public function handle()
    {
        /*
         * In production we only run migration
         */
        if (app()->environment('production')) {
            $this->call('migrate', ['--force',  true]);

            return;
        }

        /*
         * Refresh migrations
         */
        if ($this->option('refresh')) {
            $this->call('migrate:refresh');
        }

        $this->call('migrate');
    }

}
