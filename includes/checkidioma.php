<?
import("classes.language");

if($_REQUEST['idiomas'])
{
	//if($IDIOMAS[$_REQUEST['idiomas']]["text"])
	$_SESSION['idioma']=$_REQUEST['idiomas'];
	
	if(!$_SESSION['idioma'])
	$_SESSION['idioma']="es";
}
else
{
	if(!$_SESSION['idioma'])
	$_SESSION['idioma']="es";
}

global $lang;



$lang= new Language($_SESSION['idioma']);
define("ELIDIOMA",$_SESSION['idioma']);

?>