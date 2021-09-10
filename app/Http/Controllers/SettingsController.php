<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SettingsController extends Controller
{
    //

    public function index(Request $request){
        return view('admin.settings.index');
    }

    public function save_settings(Request $request){
        try{

            $data = $request->all();
            $keys = array_keys($data);


            foreach ($keys as $key){

                $has_file = $request->hasFile($key);
                $setting = Settings::where('name', $key)->first();

                if($setting){
                    $setting->value = $has_file ? "placeholder" : $data[$key];
                    $setting->save();
                }else{
                    $setting = new Settings();
                    $setting->name = $key;
                    $setting->value = $has_file ? "placeholder" : $data[$key];
                    $setting->save();
                }

                // Save file if it exists
                if ($has_file){
                    $setting->media()->delete();
                    $setting->addMediaFromRequest($key)
                            ->toMediaCollection($key);

                    $setting->value = $setting->getFirstMedia($key)->getUrl();
                    $setting->save();
                }

            }

            return response()->json([
                'status' => 'success',
                'message' => 'Settings saved successfully']);
        }catch (\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'], 500);
        }





    }
}
