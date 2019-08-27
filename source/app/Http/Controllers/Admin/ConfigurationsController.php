<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Log;

class ConfigurationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        session(['mainPage' => $request->fullUrl()]);
        $breadcrumbs = [
            'title' => __('admin.configurations.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/configurations'),
                    'text' => __('admin.configurations.breadcrumbs.title')
                ]
            ]
        ];
        
        $enable_price = Configuration::where('config_key','ENABLE_PRICE')->first();

        $group_one = Configuration::where('config_type', 1)->get();
        foreach ($group_one as $configuration){
            $configuration->config_value = json_decode($configuration->config_value, true);
        }

        $group_two = Configuration::whereIn('config_type',[2,4])->get();
        foreach ($group_two as $configuration){
            if ($configuration->config_type == 2) {
                if ($configuration->config_key == 'LOGO') {
                    $configuration->config_value = ['image' => $configuration->config_value];
                } else {
                    $configuration->config_value = ['face_and_email' => $configuration->config_value];
                }
            } else {
                $configuration->config_value = ['localization' => $configuration->config_value];
            }
        }

        $group_three = Configuration::where('config_type',3)->get();
        foreach ($group_three as $configuration){
            $configuration->config_value = ['promotion_display' => $configuration->config_value];
        }

        $group_four = Configuration::where('config_type',5)->get();
        foreach ($group_four as $configuration){
            $configuration->config_value = ['login' => $configuration->config_value];
        }

        $group_five = Configuration::where('config_type', 6)->get();
        foreach ($group_five as $configuration) {
            $configuration->config_value = ['contact' => $configuration->config_value];
        }

        $group_six = Configuration::where('config_type', 7)->get();
        foreach ($group_six as $configuration){
            $configuration->config_value = ['sms_message' => $configuration->config_value];
        }

        return view('admin.configurations.index', compact( 'breadcrumbs','enable_price', 'group_one', 'group_two', 'group_three', 'group_four', 'group_five', 'group_six'));
    }

    public function update(Request $request)
    {
        $requestData = $request->all();
        
        $enable_price = 0;
        if(isset($requestData['enable_price'])){
            $enable_price = 1;
        }
        $configuration = Configuration::where('config_key','ENABLE_PRICE')->first();
        if(empty($configuration)){
            $configuration = new Configuration;
            $configuration->config_value = $enable_price;  
            $configuration->config_key = 'ENABLE_PRICE';   
            $configuration->config_type = 8;              
            $configuration->save();
        }else{
            $configuration->config_value = $enable_price; 
            $configuration->save();
        }

        

        Session::flash('flash_message', trans('admin.configurations.flash_messages.update'));
        return redirect('admin/configurations');
    }

    public function upload()
    {
        return;
    }
}
