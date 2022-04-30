<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UpdateChazos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chazos:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Chazos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Pull from github
        print("🚀 Updating...\n");
        $process = new Process(["git", "pull", "origin", "main"]);
        $process->run();

        // Install deps
        print("🚀 Installing dependencies\n");
        $process = new Process(['composer', 'update']);
        $process->setTimeout(3600);
        $process->setIdleTimeout(3600);
        $process->run();

        // Configure caches
        print("🗃 Configuring caches\n");
        $process = new Process(["php", "artisan", "config:cache"]);
        $process->run();
        
        // Run migrations
        print("⬆️ Running migrations\n");
        $process = new Process(["php", "artisan", "migrate"]);
        $process->run();

        print("✅ Updated\n");
        return 0;
    }
}
