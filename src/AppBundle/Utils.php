<?php
namespace AppBundle;

class Utils
{
	public static function datetime_diff_minutes(\DateTime $date1, \DateTime $date2)
	{
		return floor(abs($date1->getTimestamp()-$date2->getTimestamp())/60);
	}
}
