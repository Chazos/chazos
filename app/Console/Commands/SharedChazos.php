<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SharedChazos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chazos:shared';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes the project ready for shared hosting. Note the project must be in development mode.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function replace_in_file($path, $oldContent, $newContent)
    {
        
        if (file_exists($path)){
            $str = file_get_contents($path);
            $str = str_replace($oldContent, $newContent, $str);
            file_put_contents($path, $str);
        }else{
            print("❌ Path $path does not exist\n");
        }
    }



    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        print("⏳️ Swicthing to shared hosting mode\n");
        $filename = "public/index.php";

        if (file_exists($filename)){
            File::move($filename, "index.php");
            $this->replace_in_file("index.php", "__DIR__.'/../bootstrap/app.php", "__DIR__.'/bootstrap/app.php");
            $this->replace_in_file("index.php", "__DIR__.'/../vendor/autoload.php", "__DIR__.'/vendor/autoload.php");
            $this->replace_in_file("index.php", "__DIR__.'/../storage/framework/maintenance.php", "__DIR__.'/storage/framework/maintenance.php");
            $this->replace_in_file("config/app.php", "env('ASSET_URL', null)", "env('ASSET_URL', '/public')");
            $this->replace_in_file(".env", "APP_DEBUG=true", "APP_DEBUG=false");
            $this->replace_in_file(".env", "APP_ENV=local", "APP_ENV=production");
            print("🚀 Now in deploy mode[shared hosting]\n");
        }else{
            print("ℹ️ Project might be already in deploy mode\n");
            
        }

        return 0;
    }
}
