<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use stdClass;

class PluginController extends Controller
{
    public function index(Request $request)
    {
        $plugins_list = [];

        // Get file lists of all plugins
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        foreach ($plugin_dirs as $plugin_dir) {

            $plugin_name = basename($plugin_dir);
            $plugin_details = base_path("app/Plugins/$plugin_name/$plugin_name.php");
            include($plugin_details);
            $plugins_list[] = json_decode(json_encode($plugin_info));
        }

        return view('admin.plugins.all_plugins', ['plugins' => $plugins_list]);
    }

    public function activate(Request $request, $plugin_name)
    {
        // Get file lists of all plugins
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        foreach ($plugin_dirs as $plugin_dir) {

            $plugin_actual_name = basename($plugin_dir);

            if ($plugin_actual_name == $plugin_name) {
                $plugin_details = base_path("app/Plugins/$plugin_actual_name/$plugin_actual_name.php");
                include($plugin_details);
                $plugin_info =  $plugin_info;
                $plugin_info['installed'] = 1;
                $this->writePluginConfig($plugin_info, $plugin_name);
                break;
            }
        }

        return response()->json(['status' => 'success', 'message' => "Plugin Activated successfully"]);
    }

    public function deactivate(Request $request, $plugin_name)
    {
        // Get file lists of all plugins
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        foreach ($plugin_dirs as $plugin_dir) {

            $plugin_actual_name = basename($plugin_dir);

            if ($plugin_actual_name == $plugin_name) {
                $plugin_details = base_path("app/Plugins/$plugin_actual_name/$plugin_actual_name.php");
                include($plugin_details);
                $plugin_info =  $plugin_info;
                $plugin_info['installed'] = 0;
                $this->writePluginConfig($plugin_info, $plugin_name);
                break;
            }
        }

        return response()->json(['status' => 'success', 'message' => "Plugin Deactivated"]);
    }

    public function delete(Request $request, $plugin_name)
    {
        $status = "failed";
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        foreach ($plugin_dirs as $plugin_dir) {

            $plugin_actual_name = basename($plugin_dir);
            $plugin_dir = base_path("app/Plugins/$plugin_actual_name");

            if ($plugin_actual_name == $plugin_name) {
                File::deleteDirectory($plugin_dir);
                $status = "success";
                break;
            }
        }

        if ($status == "success") {
            return response()->json([
                'status' => $status,
                'message' => "Plugin deleted successfully"
            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => "Plugin not found"
            ]);
        }
    }

    public function install(Request $request)
    {
        $status = "failed";
        $plugin_dirs = File::directories(base_path('app/Plugins'));

        Validator::make($request->all(), [
            'plugin_zip' => 'required|mimes:zip'
        ])->validate();

        $zip_file = $request->file('plugin_zip');
        $zip_file_name = $zip_file->getClientOriginalName();
        $zip_file->move(base_path('app/Plugins'), $zip_file_name);

        $zip = new \ZipArchive;
        $res = $zip->open(base_path('app/Plugins/' . $zip_file_name));
        if ($res === TRUE) {
            $zip->extractTo(base_path('app/Plugins'));
            $zip->close();
            File::delete(base_path('app/Plugins/' . $zip_file_name));
            $status = "success";

            // Delete bad files
            $plugin_dirs = File::directories(base_path('app/Plugins'));
            $bad_files_names = ['.', '..', '__MACOSX'];

            foreach ($plugin_dirs as $plugin_dir) {
                $plugin_name = basename($plugin_dir);

                if (in_array($plugin_name, $bad_files_names)) {

                    File::deleteDirectory($plugin_dir);
                    continue;
                } else {
                    // Set installed status to false
                    $plugin_details = base_path("app/Plugins/$plugin_name/$plugin_name.php");
                    include($plugin_details);
                    $plugin_info =  $plugin_info;
                    $plugin_info['installed'] = false;

                    $this->writePluginConfig($plugin_info, $plugin_name);
                }
            }
        }

        if ($status == "success") {
            return response()->json([
                'status' => $status,
                'message' => "Plugin installed successfully"
            ]);
        } else {
            return response()->json([
                'status' => $status,
                'message' => "Plugin not found"
            ]);
        }
    }

    private function writePluginConfig($plugin_info, $plugin_name)
    {
        $plugin_info_str = "\$plugin_info = [";
        foreach ($plugin_info as $key => $value) {

            if (is_array($value)) {
                $plugin_info_str .= "'$key' => [";
                foreach ($value as $key2 => $value2) {
                    $plugin_info_str .= "'$key2' => '$value2',";
                }
                $plugin_info_str .= "],";
            } else {
                $plugin_info_str .= "'$key' => '$value',";
            }
        }

        $plugin_info_str .= "\t\t];";
        file_put_contents(base_path("app/Plugins/$plugin_name/$plugin_name.php"), "<?php\n" . $plugin_info_str);
    }
}
