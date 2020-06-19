<?php

use Gunter1020\ical\CalendarHelper;
use PHPUnit\Framework\TestCase;

class CalendarHelperTest extends TestCase
{
    public function testInit()
    {
        $contents = CalendarHelper::init('Gunter_iCal')
            ->addEvent([
                'title' => '上班',
                'content' => '上班 -> 下班',
                'contentHTML' => '<h1>上班 -> 下班</h1>',
                'start' => '2020-06-01 09:00:00',
                'end' => '2020-06-01 18:00:00',
            ])
            ->output();

        $prefix = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:Gunter_iCal\r\n";

        $this->assertStringStartsWith($prefix, $contents);
    }
}