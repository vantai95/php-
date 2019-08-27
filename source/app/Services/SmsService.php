<?php

namespace App\Services;

use Log;
use App\SDK\SpeedSMSAPI;
use Exception;

class SmsService
{
    public static function sendSms($phone, $content)
    {
        try{
            $token = env('smsToken');

            $smsAPI = new SpeedSMSAPI($token);

            $phones = [$phone];

            $type = SpeedSMSAPI::SMS_TYPE_FIXNUMBER;

            $sender = "brandname";

            $response = $smsAPI->sendSMS($phones, $content, $type, $sender);

            if($response['status'] == 'success')
            {
                Log::info("Send SMS success");
                return ['success' => true];
            }else
            {
                Log::info("Send SMS false");
                return ['success' => false];
            }
        }catch (Exception $e){
            Log::info("Exception: Send SMS false");
            return ['success' => false];
        }
    }
}