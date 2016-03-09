<?php 

$system_folder="";
if (function_exists ( 'realpath' ) and @realpath ( dirname ( __FILE__ ) ) !== FALSE)
			$system_folder = realpath ( dirname ( __FILE__ ) );

 define('LIVE_SITE', "http://".$_SERVER['HTTP_HOST']."/talia/");
 define('LIVE_SITE_ADMIN', "http://".$_SERVER['HTTP_HOST']."/talia/admin/");
 define('ADMIN_FOLDER', 'admin');
 define('SEPARATOR','\\');
 define('FILESUPLOAD', $system_folder.SEPARATOR."volatil".SEPARATOR);
 define('PATH_IDIOMA', $system_folder.SEPARATOR."lang".SEPARATOR);
 
 
 define('ROOT','includes/');
 
 define("DATABASE", 'talia');
 define("HOST", 'localhost');
 define("USER", 'root');
 define("PASS", 'root');
 
 define('MAX_REGISTROS_PAGE', 20);
 define('MAX_LINKS_PAGE', 20);
 
 define('MAX_REGISTROS_PAGE_FRONT', 10);
 define('MAX_LINKS_PAGE_FRONT', 20);
 
 define('MAX_REGISTROS_PAGE_VALORAR', 25);
 define('MAX_LINKS_PAGE_FRONT_VALORAR', 20);
 define('GOOGLEANALITICS', 0);
 
 define('TEMPLATE', 'generico');
 
 include_once('data.php');
 include_once('import.php');

  ?>