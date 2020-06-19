<?php

namespace Gunter1020\ical;

use DateTime;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;

class CalendarHelper
{
    /**
     * Abstract Calender Component.
     *
     * @var Calendar
     */
    private $_calendar;

    /**
     * Construct
     *
     * @param string $product
     */
    public function __construct($product)
    {
        $this->_calendar = new Calendar($product);
    }

    /**
     * Initialize
     *
     * @param string $product
     * @return CalendarHelper
     */
    public static function init($product)
    {
        return new self($product);
    }

    /**
     * Add calender event
     *
     * @param array $config
     * @return CalendarHelper
     */
    public function addEvent($config = [])
    {
        $event = new Event();

        if (isset($config['title'])) {
            $event->setSummary($config['title']);
        }

        if (isset($config['content'])) {
            $event->setDescription($config['content']);
        }

        if (isset($config['contentHTML'])) {
            $event->setDescriptionHTML($config['contentHTML']);
        }

        if (isset($config['start'])) {
            $start = date('Y-m-d H:i:s', strtotime($config['start']));
            $event->setDtStart(new DateTime($start));
        }

        if (isset($config['end'])) {
            $end = date('Y-m-d H:i:s', strtotime($config['end']));
            $event->setDtStart(new DateTime($end));
        }

        if (isset($config['busyStatus'])) {
            $event->setMsBusyStatus($config['busyStatus']);
        }

        if (isset($config['location']['address'])) {
            $address = $config['location']['address'];
            $title = $config['location']['title'] ?? '';
            $gps = $config['location']['gps'] ?? null;
            $event->setLocation($address, $title, $gps);
        }

        $this->_calendar->addComponent($event);

        return $this;
    }

    /**
     * Return iCal contents
     *
     * @return string
     */
    public function output()
    {
        return $this->_calendar->render();
    }

    /**
     * Send iCal file
     *
     * @param string $filename
     * @return void
     */
    public function send($filename = 'cal.ics')
    {
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename . '; filename*=UTF-8\'\'' . $filename);
        echo $this->_calendar->render();
        exit;
    }
}
