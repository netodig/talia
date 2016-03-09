<?php
  define('ROOT', str_replace("\\", '/', dirname ( __FILE__ )).'/');
  
  define('LIVE_SITE', 'http://localhost/myproject/');
  
  define("DATABASE", "");
  define("HOST", "");
  define("USER", "");
  define("PASS", "");
  
/*SMTP*/
 define('HOST_SMTP', 'localhost');
 define('SMTP_PORT', 25);
 define('IS_AUTH', false); //si requiere autenticacion
 define('USER_SMTP', '');
 define('PASS_SMTP', '');
 define('MAIL_SYSTEM', 'admin@localhost.com');
 define('IS_SMTP_SERVER', true);
/*SMTP*/

function import($file)
{
    $include= str_replace(".","/",$file);
    $include=ROOT.$include.".php";
    if(file_exists($include))
     include_once($include);
}

import('dboHelper');
include(ROOT.'jfactory.php');

?>