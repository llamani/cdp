<?php

require("header.php");

if (!empty($_GET['page']))
	$page = $_GET['page'];
else {
    //TODO : Check if the user is connected
    $page = 'login';
}

$page = "$page.php";

if (!is_readable($page))
	echo "Error: $page not found";
else
	include("$page");	


require("footer.php");
?>