<?php

function strip_twitter($twitter) {
	$twitter = trim($twitter);
	$first = substr($twitter, 0, 1);
	
	if ($first == "@") {
		$twitter = substr($twitter, 1);
	}

	return $twitter;
}

?>