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
            $response = new Response('Yep, this is a leap year! Have fun!' . rand());
        } else {
			$response = new Response('Nope, this is not a leap year. Wait for it.');
		}

		// Time to Live = 10 seconds
		$response->setTtl(10);

        return $response;
    }
}