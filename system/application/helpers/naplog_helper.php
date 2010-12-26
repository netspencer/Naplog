<?php

function strip_twitter($twitter) {
	$twitter = trim($twitter);
	$first = substr($twitter, 0, 1);
	
	if ($first == "@") {
		$twitter = substr($twitter, 1);
	}

	return $twitter;
}

function find_at_user($text) {
	$url_search = "%(?<!\S)@([A-Za-z0-9_]+)%";
	$url_replace = "<a href=\"".base_url()."user/$1\">@$1</a>";
	return preg_replace($url_search,$url_replace,$text);
}

function find_links($text) {
	$url_search = "@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@";
	$url_replace = "<a href=\"$1\">$1</a>";
	return preg_replace($url_search,$url_replace,$text);
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