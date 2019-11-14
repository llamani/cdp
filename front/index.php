<?php

require("header.php");

if (!empty($_GET['page']))
	$page = $_GET['page'];
else {
    $page = 'login';
}

//TODO : Check if the user is connected


$page = "$page.php";

if (!is_readable($page))
	echo "Error: $page not found";
else
	include("$page");


require("footer.php");
?>
