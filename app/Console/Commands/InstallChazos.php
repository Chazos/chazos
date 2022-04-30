<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class InstallChazos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chazos:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Chazos';

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

        // Install deps
        print("🚀 Installing dependencies\n");
        $process = new Process(['composer', 'update']);
        $process->setTimeout(3600);
        $process->setIdleTimeout(3600);
        $process->run();
        
        // Clean the project
        print("🧹 Cleaning project\n");
        $process = new Process(["php", "artisan", "project:clean"]);
        $process->run();

        // Configure caches
        print("🗃 Configuring caches\n");
        $process = new Process(["php", "artisan", "config:cache"]);
        $process->run();
        
        // Run migrations
        print("⬆️ Running migrations\n");
        $process = new Process(["php", "artisan", "migrate"]);
        $process->run();
        
        // Seed the db
        print("🌱 Seeding the database\n");
        $process = new Process(["php", "artisan", "db:seed"]);
        $process->run();

        // Linking the storage
        print("〜 Linking storage\n");
        $process = new Process(["php", "artisan", "storage:link"]);
        $process->run();

        print("✅ Installed\n");
        return 0;
    }
}
