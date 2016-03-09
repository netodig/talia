<?php 
session_start();
include("config.php");
import("classes.helper");

$controller=$_REQUEST['controller'];
if($controller)
{
	include("controller/$controller.php");
}
?>
