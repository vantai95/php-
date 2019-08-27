<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use Session;
use App;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Configuration;
use View;
use Request;
use Lang;
use App\Services\CommonService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        URL::forceScheme('https');
        view()->composer('*', function ($view)
        {

            if(Session::get('locale')=='') {
                Session::put('locale', "vi");
            }
            $language = Session::get('locale');
            $uppercase_lang_text = strtoupper(trans("$language"));
            $menus = Menu::with(['subMenus'=>function($q) use($language){
                                  $q->where('active', true)->select('*',"name_$language as sub_menu_name");
                            }])
                        ->where('active', true)
                        ->orderBy('sequence', 'asc')
                        ->select('menus.*', "name_$language as name")
                        ->get();

            //load config facebook message url
            $facebook_message_url = Configuration::where('config_key', 'FACEBOOK_MESSAGE_URL')->first()->config_value;

             //Load icon and url
            $urlIcons = Configuration::where('config_type',1)
                ->where('config_value', 'not like', "%\"url\":null%")
                ->where('config_value', 'like', "%\"is_publish\":true%")
                ->get();

            //Load logo
            $logo = '';
            $data = Configuration::where('config_key','LOGO')->first();
            if(!empty($data)){
                $logo = $data->config_value;
            }
            $status_of_localization ='vi';
            $view->with('menuInfos', $menus);
            $view->with('logo', $logo);
            $view->with('status_of_localization', $status_of_localization);
            $view->with('facebook_message_url', $facebook_message_url);

        });

        Validator::extend('is_duplicated', function ($attribute, $value, $parameter, $validator){
            return count($value) == count(array_unique($value));
        });

        Validator::extend('at_least_one',function ($attribute, $value, $parameter, $validator){
            foreach ($value as $key => $val){
                if($val > 0){
                    return true;
                }
            }
            return false;
        });

        Validator::extend('html_required', function($attribute, $value, $parameters, $validator) {
            if(!empty($value) && strlen(trim(strip_tags($value))) > 0){
                return true;
            }
            return false;
        });

        Validator::extend('embed_link', function($attribute, $value, $parameters, $validator) {
          //
          $embedValue = substr($value,0,30);
          if($embedValue == ""){
            return true;
          }
          if($embedValue == "https://www.youtube.com/embed/"){
            if(strpos($value, ' ') !== false){
              return false;
            }
            return true;
          }else{
            return false;
          }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
