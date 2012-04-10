<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;

class LeapYearController
{
    public function indexAction($year)
    {

        $leapyear = new LeapYear();

        if ($leapyear->isLeapYear($year[0])) {
            return new Response('Yep, this is a leap year! Have fun!');
        }

        return new Response('Nope, this is not a leap year. Wait for it.');
    }
}