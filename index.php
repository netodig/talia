<?php 
session_start();
include("config.php");
import("classes.helper");
import("checkidioma");
import("messagetreat");
import("acl");

$estaLoguado = $_SESSION['iduser'] != 0 && ($_SESSION['tipoUser']==1 || $_SESSION['tipoUser']==2);

$controller=$_REQUEST['controller'];
if($controller)
{
	include("controller/$controller.php");
}

$module=$_REQUEST['module'];
if(!$module)
$module="history/listado";
//include("controller/breadcumb.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo Url::siteurl() ?>/assets/css/general.css" rel="stylesheet"/>
<link href="<?php echo Url::siteurl() ?>/assets/css/tipography.css" rel="stylesheet"/>
<link href="<?php echo Url::siteurl() ?>/assets/css/jquery.ui.all.css" rel="stylesheet"/>
<link href="<?php echo Url::admin() ?>/assets/css/template.css" rel="stylesheet"/>
<link href="<?php echo Url::siteurl() ?>/assets/css/template.css" rel="stylesheet"/>

<link href="<?php echo Url::admin() ?>/assets/css/tipography.css" rel="stylesheet"/>
<link href="<?php echo Url::siteurl() ?>/assets/css/magnific-popup.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/tooltipster.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo Url::siteurl() ?>/assets/css/vendor/normalize.css">
<link href="<?php echo Url::siteurl() ?>/assets/css/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">

<script language="javascript">
SITEURLCOMPLETA='<? echo LIVE_SITE ?>';
var MENSAJE_REQUERIDO="Campo requerido";
var MENSAJE_NUMBER="Debe ser un valor numerico";
var EMAIL_INVALIDO="Email invalido";

</script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.core.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.widget.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery_validate.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.slider.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/<?php echo ADMIN_FOLDER ?>/assets/js/funcionesj.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/<?php echo ADMIN_FOLDER ?>/assets/js/f.js"></script>

<script type="text/javascript" src="<?php echo Url::siteurl()?>/includes/js/npframej.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/includes/js/dropzone.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/includes/js/jquery.filedrop.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/includes/js/images.js"></script>
<title><?php echo $lang->g('TITLE_FRONT') ?></title>
</head>
<body>
<div class="container">
  <div class="header">
    <div class="logo"><img src="<?php echo Url::admin() ?>/assets/img/logo.png" /></div>
    <div class="menuinfo"></div>
  </div>
  <?php if($estaLoguado)
		include("modules/partial/menu.php");

?>
  <div class="contened">
    <?php 
  if(!$estaLoguado)
  {
	  include_once('modules/partial/login.php');
  }
  else
  if($module)
  {
  include("modules/$module.php");
  }
  
  ?>
  </div>
</div>
</body>
</html>