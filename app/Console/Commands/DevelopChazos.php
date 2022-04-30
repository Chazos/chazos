<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DevelopChazos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chazos:develop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch to development mode. Note the project should be in shared hosting mode.';

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
        $filename = "index.php";
        if (file_exists($filename)){
            print("👨🏽‍💻 Switching to develop mode\n");

            
            $this->replace_in_file("index.php", "__DIR__.'/bootstrap/app.php", "__DIR__.'/../bootstrap/app.php");
            $this->replace_in_file("index.php", "__DIR__.'/vendor/autoload.php", "__DIR__.'/../vendor/autoload.php");
            $this->replace_in_file("index.php", "__DIR__.'/storage/framework/maintenance.php", "__DIR__.'/../storage/framework/maintenance.php");
            $this->replace_in_file("config/app.php", "env('ASSET_URL', '/public')", "env('ASSET_URL', null)");
            $this->replace_in_file(".env", "APP_DEBUG=false", "APP_DEBUG=true");
            $this->replace_in_file(".env", "APP_ENV=production", "APP_ENV=local");
            File::move($filename, "public/index.php");
            print("👨🏽‍💻 Now in develop mode\n");
        }else{
            print("👨🏽‍💻 Already in developer mode\n");
        }
    return 0;
    }
}
