<?
import("classes.acl");
global $Acl;
$Acl= new Acl($_SESSION['tipoUser'],1);

$mod=$_REQUEST['module'];
/*
if($mod && !$Acl->has($mod,'acc'))
{
$_REQUEST['module']="partial/login";
$com["message"]="No tiene permiso de acceso al modulo.";
$com["clase"]="error";
}*/

/*$com= array();
$mod=$_REQUEST['module'];

switch($mod)
	{	
		case "opiniones/valorar":
		{
			if(!$_SESSION['userid'])
			{
				//redirecciono al login
				$_REQUEST['module']="home/login";
				$com["message"]="Si es un usuario registrado debe loguearse para valorar, sino debe registrarse.";
				$com["clase"]="error";
				$_REQUEST['where']=Url::valorar();
			}
			
		 break;
		}
	}*/
?>