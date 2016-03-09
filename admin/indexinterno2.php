<?php 
if(!defined("INDEX"))
{
	header("location:index.php");
}

$estaLoguado = $_SESSION['iduser'] != 0 && ($_SESSION['tipoUser']==1 || $_SESSION['tipoUser']==3);
$estaLoguado = $_SESSION['iduser'] != 0;
$controller=$_REQUEST['controller'];
if($controller)
{
	include("controller/$controller.php");
}

$ishome=false;
$module=$_REQUEST['module'];
if(!$module)
{
$ishome=true;	
$module="home/general";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/general.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/tipography.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::admin() ?>/assets/css/jquery.ui.all.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::admin() ?>/assets/css/template.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::admin() ?>/assets/css/tipography.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/magnific-popup.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::admin() ?>/assets/css/media.css" rel="stylesheet"/>
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="<?php echo Url::siteurl() ?>/assets/css/tooltipster.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="<?php echo Url::siteurl() ?>/assets/css/rueda.css">
<script language="javascript">
SITEURLCOMPLETA='<? echo LIVE_SITE ?>';
var MENSAJE_REQUERIDO="Campo requerido";
var MENSAJE_NUMBER="Debe ser un valor numerico";
var EMAIL_INVALIDO="Email invalido";

</script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.core.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.widget.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.tabs.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.tooltipster.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery_validate.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.tinylimiter.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.mouse.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/jquery.ui.slider.js"></script>
<!--<script type="text/javascript" src="<?php echo Url::siteurl() ?>/<?php echo ADMIN_FOLDER ?>/assets/js/tiny_mce/tiny_mce.js"></script>-->
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/<?php echo ADMIN_FOLDER ?>/assets/js/funcionesj.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl() ?>/<?php echo ADMIN_FOLDER ?>/assets/js/f.js"></script>
<script type="text/javascript" src="<?php echo Url::siteurl()?>/includes/js/npframej.js"></script>
<title>Administración</title>
</head>
<body class="loged">
<div class="container">
  <div class="header">
    <div class="logo hide_mobile"><a href="<?php echo Url::adminlink("", "") ?>"><img src="<?php echo Url::admin() ?>/assets/img/logo.png" /></a></div>
    <div class="menuinfo">
      <?php if($estaLoguado)
		include("modules/partial/menu.php");
?>
    </div>
  </div>
  <div class="infousermenu">

  </div>
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
<footer>
  <div class="ultimatefooter">
    <div class="inner tc"> © 2016 TALIA. Todos los derechos reservados. </div>
  </div>
</footer>
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
            $('.tooltip').tooltipster();
        });
</script>