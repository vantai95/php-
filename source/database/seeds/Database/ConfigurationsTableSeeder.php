<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = [
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 1,
                'config_key' => 'FACEBOOK_LINK',
                'config_value' => '{"url":"https://www.facebook.com/","image":"fb.png","is_publish":true}'
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 1,
                'config_key' => 'LINKEDIN_LINK',
                'config_value' => ""
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 1,
                'config_key' => 'TWITTER_LINK',
                'config_value' => '{"url":"https://www.twitter.com/","image":"twitter.png","is_publish":true}'
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 1,
                'config_key' => 'YOUTUBE_LINK',
                'config_value' => ""
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 1,
                'config_key' => 'INSTAGRAM_LINK',
                'config_value' => ""
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 2,
                'config_key' => 'LOGO',
                'config_value' => 'logo.png'
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 2,
                'config_key' => 'FACEBOOK_MESSAGE_URL',
                'config_value' => 'https://www.facebook.com/FishSauce-2377269555647449&appId=1040240006156811'
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 2,
                'config_key' => 'EMAIL_ADMIN_RECEIVED',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 3,
                'config_key' => 'PROMOTION_DISPLAY',
                'config_value' => 2
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 4,
                'config_key' => 'LOCALIZATION',
                'config_value' => 1
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 5,
                'config_key' => 'LOGIN_FACEBOOK',
                'config_value' => 0
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 5,
                'config_key' => 'LOGIN_GOOGLE',
                'config_value' => 0
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_NAME_EN',
                'config_value' => ''
            ]
            ,
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_NAME_VI',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_NAME_JA',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_ADDRESS_EN',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_ADDRESS_VI',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_ADDRESS_JA',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_EMAIL',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 6,
                'config_key' => 'CONTACT_PHONE',
                'config_value' => ''
            ],
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'config_type' => 7,
                'config_key' => 'SMS_MESSAGE',
                'config_value' => '$name have just confirmed order/booking on thefishsauce.vn'
            ]
        ];

        if(DB::table('configurations')->count() == 0){
            DB::table('configurations')->insert($configurations);
        }
    }
}

