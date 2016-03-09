<?php 
include("config.php");
include("easyphpthumbnail.php");

$thumb = new easyphpthumbnail();
//$thumb->Thumbsize = $_REQUEST['w'];

if($_REQUEST['w'])
 $thumb->Thumbwidth = $_REQUEST['w'];
 
if($_REQUEST['h'])
 $thumb->Thumbheight = $_REQUEST['h'];
 
if($_REQUEST['water'])
 $thumb->Watermarkpng = Url::waterMark(); 

//$thumb->Inflate = 1;
 
//para hacerle bordes redondos a la imagen
if($_REQUEST['corners'])
{
	$thumb -> Backgroundcolor = '#6b2222';
    $thumb->Clipcorner = array(2,7,0,1,1,1,1);
    $thumb->Quality = 100;
    $thumb->Framewidth = -1;
    $thumb -> Sharpen = true;
}

$thumb->Thumblocation="tmp".SEPARATOR;
$thumb->Thumbprefix="";

$rutamd5=$system_folder.SEPARATOR."tmp".SEPARATOR.md5($_REQUEST['thumb']);

echo $thumb->Createthumb($_REQUEST['thumb']);
/*$id=fopen($rutamd5,"w+");
$data="";
ob_start();

$data=ob_get_contents();
ob_clean();
fwrite($id, $data);
fclose($id);*/


