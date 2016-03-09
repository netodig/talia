<?php
session_start();
include("../../config.php");

import("classes.jsonclass");
import("classes.helper");
import('classes.mail.phpmailer');
import('classes.classmail');

$json= new JSON();

 $taske=$_GET['task'];
 
 $imprimeJson="";
 $imprimir=true;
 
 switch($taske)
 {
	 case "delmodulo":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new PmodulosExtend();
                    $cod  = $cod ->getPmodulosById($cid);
                    $cod  = $cod [0];
					
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	 case "deltaske":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new PmodulosTaskExtend();
                    $cod  = $cod ->getById($cid);
					
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	 
	 
	case "deluser":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $u = new UserinterExtend();
                    $u  = $u ->getUserinterById($cid);
                    $u  = $u [0];
                    $u->Delete();
   		}
		$imprimir=false;
		break;
	}

	 case "delcod":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new CodTiposExtend();
                    $cod  = $cod ->getCodTiposById($cid);
                    $cod  = $cod [0];
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	 case "delidioma":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new IdiomasTExtend();
                    $cod  = $cod ->getById($cid);
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	 case "delperfil":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new PerfilesExtend();
                    $cod  = $cod ->getById($cid);
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
        case "delcodgerq":
		{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
                    $cod = new CodTiposExtend();
                    $cod  = $cod->getTiposHijos($cid);
                    if($cod)
                    {
                        foreach ($cod as $c)
                        {
                            $c->Delete();
                        }
                    }
					 $cod = new CodTiposExtend();
                    $cod  = $cod ->getCodTiposById($cid);
                    $cod  = $cod [0];
                    $cod->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	case "saveordenpie":
		{
			
			$orden=$_REQUEST['orden'];
			$pie=$_REQUEST['pie'];
			$id=$_REQUEST['id'];
			
			if(is_nan($orden))
			$orden=1;
			
			$fotos = new FotosExtend();
			$fos=$fotos->getFotosByIds($id);
			foreach($fos as $f)
			{
				$f->setOrden($orden);
				$f->setPie($pie);
				$f->Save();

			}
			$imprimir=false;			
			break;
		}
	
	case "setPrincipal":
		{
			$tabla=$_REQUEST['tabla'];
			$id=$_REQUEST['idtabla'];
			$idfoto=$_REQUEST['id'];
			
			switch($tabla)
			{
				case "local":
				{
				 $inst = new LocalExtend();
				 $inst->setPkId($id);
				 
				 $inst->setImgprincipal($idfoto);
				 $inst->Save();
				break;
				}
				
				case "zonas":
				{
				 $Zonas = new ZonasExtend();
				 $Zonas->setPkId($id);
				 
				 $Zonas->setFotoprincipal($idfoto);
				 $Zonas->Save();
				break;
				}
			}
			
			$imprimir=false;			
			break;
		}
	
	

	case "delfotoconfig":
	{
		$config = new ConfigExtend();
		$config->setPkId(1);
		
		$imagen=$_REQUEST['imagen'];
		$src=$_REQUEST['src'];
		$function="set".$imagen;
		
		$config->$function('');
		
	    @unlink(FILESUPLOAD.SEPARATOR.$src);	
		
		if($imagen=="logo")
		{
		@unlink(FILESUPLOAD."tiny".$src);
		}
		
		
		
		$config->Save();
		
		$imprimeJson=array("img"=>'<img src="'.Url::thumfoto2("","sinimagen.png",127,127).'" />');
		break;
	}
	
	
	/*case "delfotoajax":
	{
		$ids = $_REQUEST["ids"];
		$carpeta=$_REQUEST["carpeta"];
		$idcontent = $_REQUEST["idcontent"];
		
		$fotos = new FotosExtend();
		$fos=$fotos->getFotosByIds($ids);
		foreach($fos as $f)
		{

			@unlink(FILESUPLOAD.$carpeta.SEPARATOR.$f->g('nombrearchivo'));	
		}
		$fotos->eliminagrupo($ids);
		
		$imprimeJson=array("img"=>'<img src="'.Url::thumfoto2($carpeta,"sinimagen.png",127,127).'" />');
		break;
	} 	
	*/
	case "delfotoajax":
	{
		$ids = $_REQUEST["ids"];
		$carpeta=$_REQUEST["carpeta"];
		$idcontent = $_REQUEST["idcontent"];
		
		$fotos = new FotosExtend();
		$fos=$fotos->getFotosByIds($ids);
		foreach($fos as $f)
		{
			@unlink(FILESUPLOAD.$carpeta.SEPARATOR.$f->g('nombrearchivo'));	
		}
		$fotos->eliminagrupo($ids);
		
		$imprimeJson=array("img"=>'<img src="'.Url::thumfoto($carpeta,"sinimagen.png",127,127).'" />');
		break;
	} 	
		
	
	
	case "cargaGerarquico":
	{
		$idpadre = $_REQUEST["idpadre"];
		$nombre=$_REQUEST["nombre"];
		$tipo=$_REQUEST["tipo"];
		$idobj=$_REQUEST["idobj"];
		
	
		$cod= new CodTiposExtend();
		$cods= $cod->getLTipoGerarquico($tipo,$idpadre);
		
		$html=$nombre.":".THelper::select($idobj, $cods, 0,false);
			
		$imprimeJson=array("html"=>$html);
		break;
	} 	
		
	
	case "delfotos":
	{
		$ids = $_REQUEST["ids"];
		$fotos = new FotosExtend();
		
		$carpeta=$_REQUEST["carpeta"];
		$fos=$fotos->getFotosByIds($ids);

		
		foreach($fos as $f)
		{
			@unlink(FILESUPLOAD.$carpeta.SEPARATOR.$f->g('nombrearchivo'));
			
		}
		$fotos->eliminagrupo($ids);
		
		$imprimir=false;
		break;
	} 
	 	
 }

 if($imprimir){
 $data=array("datos"=>$imprimeJson);
 error_reporting(0);
 echo json_encode($imprimeJson);
// echo "[".$json->serialize($imprimeJson)."]";
 }
?>
