<?php

namespace App\Services;

use App;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;
use Lang;
use Session;
use File;

class CommonService
{
    public static function formatFullDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatShortDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatLongDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function formatFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i Y-m-d', strtotime($date));
    }

    public static function formatShortFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i', strtotime($date));
    }

    public static function formatSmsTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y/H:i', strtotime($date));
    }

    public static function formatEmailTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i d-m-Y', strtotime($date));
    }

    public static function formatDuration($minutes)
    {
        if (empty($minutes)) {
            return '';
        }

        if (!is_numeric($minutes)) {
            return '';
        }

        if ($minutes < 0){
            return '';
        }

        $hours = (int)($minutes / 60);
        $minutes = $minutes % 60;
        return $hours . 'h' . $minutes . "'";
    }

    public static function formatPrice($price)
    {
        if (empty($price)) {
            return '';
        }

        if (!is_numeric($price)) {
            return '';
        }

        if ($price < 0){
            return '';
        }
        return number_format($price, 0, ',', '.');
    }

    public static function formatPriceVND($price)
    {
        if (empty($price)) {
            return '';
        }

        if (!is_numeric($price)) {
            return '';
        }

        if ($price < 0){
            return '';
        }
        return number_format($price, 0, ',', '.') . " VND";
    }

    public static function formatInteger($number)
    {
        if (empty($number)) {
            return '';
        }

        if (!is_numeric($number)) {
            return '';
        }

        if ($number < 0){
            return '';
        }
        return number_format($number, 0, ',', '.');
    }


    public static function internationalPhoneNumber($text, $countryCode = '84')
    {
        if (empty($text)) {
            return $text;
        }

        if (starts_with($text, '0')) {
            return $countryCode . substr($text, 1);
        }

        if (starts_with($text, '+')) {
            return substr($text, 1);
        }

        return $text;
    }

    public static function getPreviousUrl($request)
    {
        $currentPage = explode('/', explode('admin/', $request->fullUrl())[1])[0];

        if (!empty(session('mainPage'))) {

            $pageAndQueries = explode('?', explode('admin/', session('mainPage'))[1]);

            $page = $pageAndQueries[0];

            $queries = isset($pageAndQueries[1]) ? $pageAndQueries[1] : null;

            if ($page == $currentPage) {

                return url("admin/$page?$queries");
            }
        }
        return url("admin/$currentPage");
    }

    public static function checkPermission($permissionKey, $isValue = false)
    {
        $permissions = Auth::user()->allPermissions();
        if (empty($permissions)) {
            session(['permissions' => $permissions]);
        }
        if ($isValue) {
            $permission = $permissionKey;
        } else {
            $permission = Role::PERMISSIONS[$permissionKey];
        }
        return isset($permissions[$permission]) && $permissions[$permission];
    }

    public static function correctSearchKeyword($keyword)
    {
        $keyword = str_replace(' ', '%', $keyword);
        return "%$keyword%";
    }

    public static function formatSendDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y', strtotime($date));
    }
    public static function formatDateTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y  H:i', strtotime($date));
    }
    public static function upperString($string){
        return strtoupper($string);
    }

    public static function containString($str,$substr){
        return strpos($str,$substr) !== false;
    }

    public static function formatLastLoginDate($date){
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d H:i', strtotime($date));
    }

    public static function formatFileSize($size){
        return round($size/1048576,2);
    }

    public static function imgUrl($image){
      if (!empty($image) && File::exists(public_path(config('constants.UPLOAD.IMAGE_LIST')) . '/' . $image)) {
          return asset(config('constants.UPLOAD.IMAGE_LIST') . '/' . $image);
      }
      return url(config('constants.DEFAULT.ITEM_IMAGE'));
    }

}
