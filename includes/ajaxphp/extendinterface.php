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
	
	case "delhistory":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
			$history = new HistoryExtend();
			$history  = $history ->getHistoria($cid);
			$history  = $history [0];
			
			$fotos = new FotosExtend();
			@unlink(FILESUPLOAD."historia".SEPARATOR.$history->g('nombrearchivo'));	

			$fotos->eliminagrupo($history->g('idfoto'));
			
			$history->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	case "delparrafo":
	{
		$cid = $_REQUEST["id"];
   		if($cid)
   		{
			$parrafo = new ParrafoExtend();
			$parrafo  = $parrafo ->getById($cid);
			$parrafo->Delete();
   		}
		$imprimir=false;
		break;
	}
	
	
	
	case "cargaprovs":
	{
		$idpadre = $_REQUEST["idpadre"];
		$idobj=$_REQUEST["idobj"];
		
	
		$cod= new CodTiposExtend();
		$cods= $cod->getLTipoGerarquico(2,$idpadre);
		
		$html="Comunidad :<br>".THelper::select($idobj, $cods, 0,false,array('onchange="cargacombos(this.value,\'lbloc\',\'localidad\',\'cargalocs\')"'));
			
		$imprimeJson=array($html);
		break;
	} 	
	
	case "cargalocs":
	{
		$idpadre = $_REQUEST["idpadre"];
		$idobj=$_REQUEST["idobj"];
		
		$cod= new CodTiposExtend();
		$cods= $cod->getLTipoGerarquico(2,$idpadre);
		
		$html="Provincia :<br>".THelper::select($idobj, $cods, 0,false,array('onchange="cargacombos(this.value,\'lbcom\',\'comunidad\',\'cargacoms\')"'));
			
		$imprimeJson=array($html);
		break;
	} 	
	
	case "cargacoms":
	{
		$idpadre = $_REQUEST["idpadre"];
		$idobj=$_REQUEST["idobj"];
		
		$cod= new CodTiposExtend();
		$cods= $cod->getLTipoGerarquico(2,$idpadre);
		
		$html="Localidad :<br>".THelper::select($idobj, $cods, 0,false);
			
		$imprimeJson=array($html);
		break;
	} 	
	
	case "cargaasociado":
	{
		$idgrupo = $_REQUEST["idgrupo"];
		$selected = $_REQUEST["selected"];
		$selected2 = $_REQUEST["selected2"];
		
		$classSector="";
		
		$arrayAsociados=array();
		$arrayAsociados[""]="Seleccionar";
		
		$arrsector=array();
		$arrsector[""]="Seleccionar";
		
		//busco todos los sectores
		$sectores= new SectoresExtend();
		$sectores= $sectores->getSectores();
		foreach($sectores as $s)
		{
			$arrsector[$s->g('id')]=$s->g('nombre');
		}

		switch($idgrupo)
		{
			case 1:	
			case 7:	
			{
				$arrayAsociados[1]=$TIPOSPRODUCTOS[$idgrupo];
				
				$classSector="hide";
				break;
			}
			case 2:
				{
					$classSector="hide";
				}
			case 2:
			case 3:
			case 4:
			{
				//busco todos los sectores
				$sectores= new SectoresExtend();
				$sectores= $sectores->getSectores();
				foreach($sectores as $s)
				{
					$arrayAsociados[$s->g('id')]=$s->g('nombre');
				}
		
				break;
			}
			case 5:
			{
				//busco todas las plantillas
				$templates= new TemplatesExtend();
				$templates= $templates->getTemplateAll(0);
				foreach($templates as $s)
				{
					$arrayAsociados[$s->g('id')]=$s->g('sectornombre')." &raquo; ".$s->g('nombre');
				}
				break;
			}
			case 6:
			{
				//busco todas las plantillas premium
				$templates= new TemplatesExtend();
				$templates= $templates->getTemplateAll(1);
				foreach($templates as $s)
				{
					$arrayAsociados[$s->g('id')]=$s->g('sectornombre')." &raquo; ".$s->g('nombre');
				}
				break;
			}
			
			
		}
		
		$html="<label class='ml2p'>Producto asociado :<br>".THelper::select('asociado', $arrayAsociados, $selected,false)."</label>";
		$html.="<label class='ml2p ".$classSector."'>Unidad de negocio :<br>".THelper::select('sector', $arrsector, $selected2,false)."</label>";
			
		$imprimeJson=array($html);
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

