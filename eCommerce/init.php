<?php
//error reporting
ini_set('display_errors' , 'On');
error_reporting(E_ALL);
	include 'admin/connect.php';
    $sessionUser ='';
	if(isset($_SESSION['user'])){
		$sessionUser = $_SESSION['user'];
	}
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
	


	

	