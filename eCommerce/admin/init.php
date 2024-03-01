<?php

	include 'connect.php';

	// Routes
    $lanng   = 'includes/languages/';
	$tpl 	= 'includes/templates/'; // Template Directory
	$func	= 'includes/functions/';
	$css 	= 'layout/css/'; // Css Directory
	$js 	= 'layout/js/'; // Js Directory
	// Include The Important Files
	include $func . 'functions.php';
	include $lanng . 'en.php';
	include $tpl . 'header.php';

	// Include Navbar On All Pages Expect The One With $noNavbar Vairable

	if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }
	

	