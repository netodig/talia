<?php 
define('PATH_UPLOADS', ROOT_FRONT.'img/volatil/big/');
define('PATH_UPLOADS_THUMBS', ROOT_FRONT.'img/volatil/');
define('URL_UPLOADS', LIVE_SITE.'img/volatil/');
define('PATH_PHPTHUMBS', LIVE_SITE_ADMIN.'includes/phpThumb/phpThumb.php');


define('ANCHO_THUMB', 123);
define('ALTO_THUMB', 123);
define('ANCHO_IMG_BIG', 500);

define('CANTMESESOFERTAINI', 1);
define('CANTMESESOFERTAFIN', 3);

define('MAX_FOTOS_PELU', 5);

//en kb
define('PESO_MAX_FOTO', 500);

define('MAX_OFERTAS', 20);

 /*SMTP*/
 define('HOST_SMTP', 'localhost');
 define('SMTP_PORT', 25);
 define('IS_AUTH', false); //si requiere autenticacion
 define('USER_SMTP', '');
 define('PASS_SMTP', '');
 define('MAIL_SYSTEM', 'netodig@edgar.com');
 define('IS_SMTP_SERVER', true);
 /*SMTP*/


define('NAMEFROME', 'Equipo cronotec.com');
define('EMAILFROM', 'netodig@edgar.com');
define('NOMBRESISTEMA', 'Equipo cronotec.com');

//en segundos
define('TIEMPOENTRMAIL', 1);
//email para contactos
define('MAIL_CONTACT', 'cronotec1@edgar.com');

$IDIOMAS=array( "es"=>array("text"=>"Español","img"=>"spain.png","langcode"=>"es"),"en"=>array("text"=>"Inglés","img"=>"england.png","langcode"=>"en"));

$TIPOSCOD=array("1"=>"Categorias");

$tipoText=array(1=>"Administrador",2=>"Persona",3=>"Empresa");

?>