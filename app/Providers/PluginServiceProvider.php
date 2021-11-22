<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //

        // Get file lists of all plugins
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        foreach ($plugin_dirs as $plugin_dir) {
            $plugin_name = basename($plugin_dir);
            $plugin_providers = File::files($plugin_dir . '/Providers');





            // Register plugin providers
            foreach ($plugin_providers as $provider) {
                $provider_name = basename($provider);

                // Correct plugin namespace error
                $file_contents = file_get_contents($provider);
                $namespace_str = "namespace App\Providers\..\Plugins\\$plugin_name\Providers;";

                $file_contents = str_replace($namespace_str, "namespace App\Plugins\\$plugin_name\Providers;", $file_contents);
                file_put_contents($provider, $file_contents);

                // Register
                $provider_class_name = str_replace(".php", "", $provider_name);
                $provider_class_path = "App\Plugins\\$plugin_name\Providers\\$provider_class_name";

                include_once("$provider");



                try{
                    $this->app->register($provider_class_path);
                    // print("Registered $plugin_name provider\n");
                }catch(\Exception $e){
                    // print("Couldnt register $plugin_name a provider");
                }

            }


        }

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
