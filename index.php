<?php
	require_once 'php/Mobile-Detect-2.8.24/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	 
	// Any mobile device (phones or tablets).
	if ( $detect->isMobile() )
		require 'mobile-view.html';
	else
		require 'pc-view.html';
?>