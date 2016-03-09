<?php 
session_start();
/*
error_reporting(E_ALL);
ini_set("display_errors","On");*/

include("../config.php");
import("classes.helper");
import("acl");
import("messagetreat");

$val = trim(ini_get('upload_max_filesize'));
  
$last = $val{strlen($val)-1};
$val=str_replace($last,"",$val);

$last=strtolower($last);

switch($last) {
case 'g':
{
$val .= ' GB';
break;
}
case 'm':
{
$val .= ' MB';
break;
}
case 'k':
{
$val .= ' Kb';
break;
}
}

$TAMANO=$val;

define("INDEX",1);

//$estaLoguado = $_SESSION['iduser'] != 0 && ($_SESSION['tipoUser']==1);

$estaLoguado = $_SESSION['iduser'] != 0 && ($_SESSION['tipoUser']==1 || $_SESSION['tipoUser']==3);
  if(!$estaLoguado)
  {
	  include_once("indexinterno1.php");
  }
  else
  {
  	include_once("indexinterno2.php");
  }
  
?>
