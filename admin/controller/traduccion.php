<?php
import('classes.mail.phpmailer');
import('classes.classmail');
import("classes.jsonclass");
//include("modules/reservas/helpers/reserva.php");

$com= array();
$task=$_REQUEST['task'];
switch($task)
	{	
		case "saveConfig":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";

			
			$traduc= new TraduccionTablaExtend();
			
			$tabla=$_REQUEST['tabla'];
			$condicion=$_REQUEST['condicion'];
			$ordenini=$_REQUEST['ordenini'];
			
			//elimino las que estan primero
			$traduc->Deltabla($tabla);	
			
			//creo los campos
			$traducciones= new TraduccionExtend();
 			$traducciones=$traducciones->getTablaDes($tabla);
			
			foreach($traducciones as $t)
			{
	
				if($_REQUEST[$t->g('Field')."traduce"])
				{
				$traduc= new TraduccionTablaExtend();
				$traduc->setTabla($tabla);
				$traduc->setCampo($t->g('Field'));
				$traduc->setTituloc($_REQUEST[$t->g('Field')."titulo"]);
				$traduc->setTipotrad($_REQUEST[$t->g('Field')."traduce"]);
				$muestraen=0;
				if($_REQUEST[$t->g('Field')."muestra"])
				$muestraen=1;
				
				$traduc->setMuestraentitulo($muestraen);
				$traduc->Save();
				}
			}
			
			$extratabla= new TraduccionTablasExtend();
			$extratabla=$extratabla->getDataTable($tabla);
			$extratabla=$extratabla[0];
			$extratabla->setOrderby($ordenini);
			$extratabla->setConsulta($condicion);
			$extratabla->Save();

			$com["message"]="Se ha guardado la información correctamente";
			$com["clase"]="goodmsg";
				
			break;
		}
		
		case "saveTraduccion":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			
			$tabla=$_REQUEST['tabla'];
			$cid=$_REQUEST['cid'];
			$idorigi=$_REQUEST['idorigi'];
			$idi=$_REQUEST['idi'];
			/*$iditext=$_REQUEST['iditext'];*/
			
			//busco los campos de esa tabla que se traducen
			$camposTabla= new TraduccionExtend();
			$camposTabla=$camposTabla->getCamposTabla($tabla);
			
			$objetosaver= new TraduccionExtend();
			
			$objetosaver->setPkId($cid);
			$objetosaver->setIdobject($idorigi);
			$objetosaver->setIdioma(0);
			$objetosaver->setIdiomat($idi);
			$objetosaver->setTabla($tabla);
			
			$arrayTraducido=array();
			foreach($camposTabla as $c)
			{
				$dato=$_REQUEST['traduce'.$c->g('campo')];
				$arrayTraducido[$c->g('campo')]=$dato;
				
			}
			
			$json= new JSON();
			
			$ar= array("datos"=>$arrayTraducido);
			$objetosaver->setTraduccion($json->serialize($arrayTraducido));
		
			//$objetosaver->setTraduccion(json_encode($arrayTraducido));

			if($objetosaver->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$objetosaver->getPkId();
			}

			
			break;
		}
		
		case "saveTablas":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";

			
			$traduc= new TraduccionTablasExtend();

			//elimino las que estan primero
			$traduc->getTablasDesc();	
			
			//guardo los titulos
			$traducciones= new TraduccionExtend();
 		    $traducciones=$traducciones->getTablas();
			
			foreach($traducciones as $t)
			{
	
				if($_REQUEST[$t->g('Tables_in_'.DATABASE)])
				{
				$traduc= new TraduccionTablasExtend();
				$traduc->setNombretabla($t->g('Tables_in_'.DATABASE));
				$traduc->setTitulotabla($_REQUEST[$t->g('Tables_in_'.DATABASE)]);
				$traduc->setCampoid($_REQUEST["ids".$t->g('Tables_in_'.DATABASE)]);
				$traduc->Save();
				}
			}
			

			$com["message"]="Se ha guardado la información correctamente";
			$com["clase"]="goodmsg";
				
			break;
		}
		case "saveidioma_t":
		{
			$com["message"]="Ocurrió un error y no se guardó la informacion";
			$com["clase"]="error";
			
			
			$id = $_REQUEST['id'];
			$nombre= $_REQUEST['nombre'];
                        $abv= $_REQUEST['abv'];
                        $act= $_REQUEST['act'];
                        if(!$act)
                        {
                            $act=0;
                        }
                        else
                        {
                            $act=1; 
                        }
			$idioma= new IdiomasTExtend();
			$idioma->setPkId($id);
			$idioma->setNombre($nombre);
			$idioma->setAbv($abv);
			$idioma->setActivo($act);
			
			if($idioma->Save())
			{
                            $com["message"]="Se ha guardado la información correctamente";
                            $com["clase"]="goodmsg";	
			}
			break;
		}
			
	}
?>