<?php
	require_once("apps.inc");

	// 
	// try to prevent external rating scripts
	// 

	if( isset($APP_RATE_COOKIE) ) {
		$ratingAry = unserialize(base64_decode($APP_RATE_COOKIE));
	}
	if( !is_array($ratingAry) ) {
		$ratingAry = array();
	}
	if( $rate >= 1 && $rate <= 5 && !array_key_exists($app_id, $ratingAry) && ereg("http://$_SERVER[SERVER_NAME]/apps", $_SERVER[HTTP_REFERER]) )  {
		mysql_query("
			UPDATE app
			SET 
				rating = (rating * votes + $rate) / (votes + 1),
				votes = votes + 1
			WHERE id = $app_id
		");

		$ratingAry[$app_id] = 1;

		SetCookie("APP_RATE_COOKIE", base64_encode(serialize($ratingAry)), time()+86400, '/' );
	}


	include_once("index.php");
?>
