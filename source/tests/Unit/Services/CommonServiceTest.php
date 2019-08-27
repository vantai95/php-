<?php

namespace Tests\Unit\Services;

use App\Services\CommonService;
use Tests\TestCase;
use Carbon\Carbon;

class CommonServiceTest extends TestCase
{
//    formatFullDate
    public function testFormatFullDateWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatFullDate($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatFullDateWhenDateValid()
    {
        $date = Carbon::create(2018, 9, 10, 14, 5, 0);
        $actual = CommonService::formatFullDate($date);
        $this->assertEquals('2018-09-10', $actual);
    }

    public function testFormatFullDateWhenDateInvalid()
    {
        $actual = CommonService::formatFullDate('asdasd');
        $this->assertEquals('1970-01-01', $actual);
    }

    // formatShortDate
    public function testFormatShortDateWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatShortDate($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatShortDateWhenDateValid()
    {
        $date = Carbon::create(2017, 9, 11, 7, 5, 0);
        $actual = CommonService::formatShortDate($date);
        $this->assertEquals('2017-09-11', $actual);
    }

    public function testFormatShortDateWhenDateInvalid()
    {
        $actual = CommonService::formatShortDate('asdasdas');
        $this->assertEquals('1970-01-01', $actual);
    }

    // formatLongDate
    public function testFormatLongDateWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatLongDate($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatLongDateWhenDateValidAndTimeEmpty()
    {
        $date = Carbon::now()->toDateString();
        $actual = CommonService::formatLongDate($date);
        $this->assertEquals($date . ' 00:00:00', $actual);
    }

    public function testFormatLongDateWhenDateEmptyAndTimeValid()
    {
        $date = Carbon::create(null, null, null, 1, 20, 30);
        $actual = CommonService::formatLongDate($date);
        $this->assertEquals($date, $actual);
    }

    public function testFormatLongDateWhenDateValidAndTimeValid()
    {
        $date = Carbon::create(2018, 10, 9, 1, 20, 30);
        $actual = CommonService::formatLongDate($date);
        $this->assertEquals('2018-10-09 01:20:30', $actual);
    }

    public function testFormatLongDateWhenDateAndTimeInvalid()
    {
        $actual = CommonService::formatLongDate('asdasdas');
        $this->assertEquals('1970-01-01 00:00:00', $actual);
    }

    //formatFlightTime
    public function testFormatFlightTimeWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatFlightTime($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatFlightTimeWhenDateValidAndTimeEmpty()
    {
        $date = Carbon::now()->toDateString();
        $actual = CommonService::formatFlightTime($date);
        $this->assertEquals('00:00 ' . $date, $actual);
    }

    public function testFormatFlightTimeWhenDateEmptyAndTimeValid()
    {
        $date = Carbon::create(null, null, null, 1, 20, 30);
        $actual = CommonService::formatFlightTime($date);
        $this->assertEquals('01:20 ' . Carbon::now()->toDateString(), $actual);
    }

    public function testFormatFlightTimeWhenDateValidAndTimeValid()
    {
        $date = Carbon::create(2018, 10, 9, 1, 20, 30);
        $actual = CommonService::formatFlightTime($date);
        $this->assertEquals('01:20 2018-10-09', $actual);
    }

    public function testFormatFlightTimeWhenDateAndTimeInvalid()
    {
        $actual = CommonService::formatFlightTime('asdasdas');
        $this->assertEquals('00:00 1970-01-01', $actual);
    }

    //formatShortFlightTime
    public function testFormatShortFlightTimeWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatShortFlightTime($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatShortFlightTimeWhenDateValidAndTimeEmpty()
    {
        $date = Carbon::now()->toDateString();
        $actual = CommonService::formatShortFlightTime($date);
        $this->assertEquals('00:00', $actual);
    }

    public function testFormatShortFlightTimeWhenDateEmptyAndTimeValid()
    {
        $date = Carbon::create(null, null, null, 1, 20, 30);
        $actual = CommonService::formatShortFlightTime($date);
        $this->assertEquals('01:20', $actual);
    }

    public function testFormatShortFlightTimeWhenDateValidAndTimeValid()
    {
        $date = Carbon::create(2018, 10, 9, 1, 20, 30);
        $actual = CommonService::formatShortFlightTime($date);
        $this->assertEquals('01:20', $actual);
    }

    public function testFormatShortFlightTimeWhenDateAndTimeInvalid()
    {
        $actual = CommonService::formatShortFlightTime('asdasdas');
        $this->assertEquals('00:00', $actual);
    }

    //formatSmsTime
    public function testFormatSmsTimeWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatSmsTime($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatSmsTimeWhenDateValidAndTimeEmpty()
    {
        $date = date('d-m-Y', strtotime(Carbon::now()));
        $actual = CommonService::formatSmsTime($date);
        $this->assertEquals($date . '/00:00', $actual);
    }

    public function testFormatSmsTimeWhenDateEmptyAndTimeValid()
    {
        $date = Carbon::create(null, null, null, 1, 20, 30)->toDateTimeString();
        $actual = CommonService::formatSmsTime($date);
        $this->assertEquals(date('d-m-Y/H:i', strtotime($date)), $actual);
    }

    public function testFormatSmsTimeWhenDateValidAndTimeValid()
    {
        $date = Carbon::create(2018, 10, 9, 1, 20, 30);
        $actual = CommonService::formatSmsTime($date);
        $this->assertEquals('09-10-2018/01:20', $actual);
    }

    public function testFormatSmsTimeWhenDateAndTimeInvalid()
    {
        $actual = CommonService::formatSmsTime('asdasdas');
        $this->assertEquals('01-01-1970/00:00', $actual);
    }

    //formatEmailTime
    public function testFormatEmailTimeWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatEmailTime($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatEmailTimeWhenDateValidAndTimeEmpty()
    {
        $date = date('d-m-Y', strtotime(Carbon::now()));
        $actual = CommonService::formatEmailTime($date);
        $this->assertEquals('00:00 ' . $date, $actual);
    }

    public function testFormatEmailTimeWhenDateEmptyAndTimeValid()
    {
        $date = Carbon::create(null, null, null, 1, 20, 30)->toDateTimeString();
        $actual = CommonService::formatEmailTime($date);
        $this->assertEquals(date('H:i d-m-Y', strtotime($date)), $actual);
    }

    public function testFormatEmailTimeWhenDateValidAndTimeValid()
    {
        $date = Carbon::create(2018, 10, 9, 1, 20, 30);
        $actual = CommonService::formatEmailTime($date);
        $this->assertEquals('01:20 09-10-2018', $actual);
    }

    public function testFormatEmailTimeWhenDateAndTimeInvalid()
    {
        $actual = CommonService::formatEmailTime('asdasdas');
        $this->assertEquals('00:00 01-01-1970', $actual);
    }

    //formatDuration
    public function testFormatDurationWhenInputEmpty()
    {
        $minute = null;
        $actual = CommonService::formatDuration($minute);
        $this->assertEquals('', $actual);
    }

    public function testFormatDurationWhenInputEqualZero()
    {
        $minute = 0;
        $actual = CommonService::formatDuration($minute);
        $this->assertEquals('', $actual);
    }

    public function testFormatDurationWhenInputIsNegative()
    {
        $minute = -1;
        $actual = CommonService::formatDuration($minute);
        $this->assertEquals('', $actual);
    }


    public function testFormatDurationWhenInputInvalid()
    {
        $actual = CommonService::formatDuration('asdasdas');
        $this->assertEquals('', $actual);
    }

    //formatPrice
    public function testFormatPriceWhenInputEmpty()
    {
        $number = null;
        $actual = CommonService::formatPrice($number);
        $this->assertEquals('', $actual);
    }

    public function testFormatPriceWhenInputValid()
    {
        $number = 1000000;
        $actual = CommonService::formatPrice($number);
        $this->assertEquals('1.000.000', $actual);
    }

    public function testFormatPriceWhenInputIsNegative()
    {
        $number = -1000000;
        $actual = CommonService::formatPrice($number);
        $this->assertEquals('', $actual);
    }


    public function testFormatPriceWhenInputInvalid()
    {
        $actual = CommonService::formatPrice('asdasdas');
        $this->assertEquals('', $actual);
    }

    //formatPriceVND
    public function testFormatPriceVNDWhenInputEmpty()
    {
        $number = null;
        $actual = CommonService::formatPriceVND($number);
        $this->assertEquals('', $actual);
    }

    public function testFormatPriceVNDWhenInputValid()
    {
        $number = 1000000;
        $actual = CommonService::formatPriceVND($number);
        $this->assertEquals('1.000.000 VND', $actual);
    }

    public function testFormatPriceVNDWhenInputIsNegative()
    {
        $number = -1000000;
        $actual = CommonService::formatPriceVND($number);
        $this->assertEquals('', $actual);
    }


    public function testFormatPriceVNDWhenInputInvalid()
    {
        $actual = CommonService::formatPriceVND('asdasdas');
        $this->assertEquals('', $actual);
    }

    //formatInteger
    public function testFormatIntegerWhenInputEmpty()
    {
        $number = null;
        $actual = CommonService::formatInteger($number);
        $this->assertEquals('', $actual);
    }

    public function testFormatIntegerWhenInputValid()
    {
        $number = 1000000;
        $actual = CommonService::formatInteger($number);
        $this->assertEquals('1.000.000', $actual);
    }

    public function testFormatIntegerWhenInputIsNegative()
    {
        $number = -1000000;
        $actual = CommonService::formatInteger($number);
        $this->assertEquals('', $actual);
    }


    public function testFormatIntegerWhenInputInvalid()
    {
        $actual = CommonService::formatInteger('asdasdas');
        $this->assertEquals('', $actual);
    }

    //internationalPhoneNumber
    public function testInternationalPhoneNumberWhenNumberEmpty()
    {
        $number = null;
        $actual = CommonService::internationalPhoneNumber($number);
        $this->assertEquals('', $actual);
    }

    public function testInternationalPhoneNumberWhenNumberStartWithZero()
    {
        $number = "01227007791";
        $actual = CommonService::internationalPhoneNumber($number);
        $this->assertEquals('841227007791', $actual);
    }

    public function testInternationalPhoneNumberWhenNumberStartWithPlus()
    {
        $number = "+01227007791";
        $actual = CommonService::internationalPhoneNumber($number);
        $this->assertEquals('01227007791', $actual);
    }

    public function testInternationalPhoneNumberWhenNumberWithCorrectFormat()
    {
        $number = "1227007791";
        $actual = CommonService::internationalPhoneNumber($number);
        $this->assertEquals('1227007791', $actual);
    }

    public function testInternationalPhoneNumberWhenNumberInvalid()
    {
        $actual = CommonService::internationalPhoneNumber('asdasdas');
        $this->assertEquals('', $actual);
    }

    //correctSearchKeyword
    public function testCorrectSearchKeywordWhenTextEmpty()
    {
        $text = null;
        $actual = CommonService::correctSearchKeyword($text);
        $this->assertEquals('%%', $actual);
    }

    public function testCorrectSearchKeywordWhenTextCorrectFormat()
    {
        $text = "My name is Thanh";
        $actual = CommonService::correctSearchKeyword($text);
        $this->assertEquals('%My%name%is%Thanh%', $actual);
    }

    //formatSendDate
    public function testFormatSendDateWhenDateEmpty()
    {
        $date = null;
        $actual = CommonService::formatSendDate($date);
        $this->assertEquals('', $actual);
    }

    public function testFormatSendDateWhenDateValid()
    {
        $date = Carbon::now();
        $actual = CommonService::formatSendDate($date);
        $this->assertEquals($date, $actual);
    }

    public function testFormatSendDateWhenDateInvalid()
    {
        $actual = CommonService::formatSendDate('asdasd');
        $this->assertEquals('01-01-1970', $actual);
    }


}
