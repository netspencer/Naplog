<?php

function strip_twitter($twitter) {
	$twitter = trim($twitter);
	$first = substr($twitter, 0, 1);
	
	if ($first == "@") {
		$twitter = substr($twitter, 1);
	}

	return $twitter;
}

function smart_timestamp($timestamp, $date_format = "j M") {
	$time = explode(',', timespan($timestamp));
	$seconds_day = 86400;
	
	if (now() - $timestamp > $seconds_day) {
		return date($date_format, $timestamp);
	} else {
		return $time[0]." ago";
	}
}

?>