<?php
import('classes.mail.phpmailer');
import('classes.classmail');

$com= array();
$task=$_REQUEST['task'];

switch($task)
	{	
		
		case "login":
		{
			$com["clase"]="errormsg";
			
			$name=$_REQUEST['usuario'];
			$pass=$_REQUEST['pass'];
			
			$u = new UserinterExtend();
			$u=$u->getLoginTipo($name, $pass,"1,3");
			
			if($u[0])
			{
				$_SESSION['iduser']=$u[0]->g('id');
				$_SESSION['name']=$name;
				$_SESSION['tipoUser']=$u[0]->g('tipo');
				header("location:".Url::sitelink(""));
			}
			else
			{
				$com["message"]=$lang->g('USERPASS_INCORRECTO');;
			}
			
		 break;
		}
		
		
		case "logout":
		{
			session_destroy();
			$_SESSION['iduser']=0;
			$_SESSION['name']=0;
			$_SESSION['tipoUser']=0;
			header("location:".Url::adminlsolo("index"));
			break;
		}
		
		case "savenfoto":
		{
			
			import("upload");
			$tipo=$_REQUEST['tipo'];
			$idtext= $_REQUEST['idt'];
			$idtext2= $_REQUEST['idt2'];
			$namefile= $_REQUEST['name'];
			$folder= $_REQUEST['f'];
			$cidfoto= $_REQUEST['fprev'];
			
			if($folder)
			$folder=$folder.SEPARATOR;
			
			if($_FILES[$namefile])
			{ 
			$handle = new upload($_FILES[$namefile]);
			$nombreImg = '';
			
			//elimino la foto anterior si hay
			if($cidfoto)
				{
					$fotos = new FotosExtend();
					$fos=$fotos->getFotosByIds($cidfoto);
					foreach($fos as $f)
					{
						@unlink(FILESUPLOAD.$folder.$f->g('nombrearchivo'));	
					}
					$fotos->eliminagrupo($cidfoto);
					$cidfoto=0;
				}
			
			NombreFileRandom('.'.$handle->file_src_name_ext, FILESUPLOAD.$folder, $nombreImg);
			$handle->file_new_name_body = $nombreImg;	
			$handle->Process(FILESUPLOAD.$folder);
			
			if($handle->processed):
			$nombrefoto = $nombreImg.'.'.$handle->file_src_name_ext;
			
			$fotos= new FotosExtend();
			$fotos->setNombrearchivo($nombrefoto);
			$fotos->setTipofoto($tipo);
			$fotos->setIdext($idtext);
			
			if($idtext2)
			$fotos->setIdtext2($idtext2);
			 	
			$fotos->Save();

			endif;
			} 
			
			$ar=array("asdasd"=>"asdasd");
			
			echo json_encode($ar);
			

			break;
		}
		
		case "savehistory":
		{
			import("upload");
			
			$com=array();
			$com["message"]=$lang->g('ERROR_PROCESO');
			$com["clase"]="errormsg";
			
			
			$cid = $_REQUEST['cid'];
			$cnombre = $_REQUEST['nombre'];
			$clanref = $_REQUEST['lanref'];
			
			$tipofoto = $_REQUEST["tipofoto"];
			$cidfoto=$_REQUEST["cidfoto"];
			
			$cdesc = $_REQUEST['desc'];
			$clevel = $_REQUEST['level'];
			$ccat = $_REQUEST['cat'];
			
			if(!$ccat)
			$ccat=0;

			$primeravez=false;
			if(!$cid)
			{
				$primeravez=true;
			}
			
			$historia = new HistoryExtend();
			$historia->setPkId($cid);			
			$historia->setNombre($cnombre);
			$historia->setCat($ccat);
			$historia->setLevel($clevel);
			$historia->setDescripcion($cdesc);
			
			if($primeravez)
			{
				$historia->setIdiomaref($clanref);
				$historia->setCreador($_SESSION['iduser']);
			}

			//la foto pricipal
			
			if($historia->Save())
			{
				$com["message"]=$lang->g('GUARDADO_CORRECTO');
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$historia->getPkId();
			}
			
			$nombrefoto="";
			if($_FILES['fotoprincipal'])
			{ 
			$handle = new upload($_FILES["fotoprincipal"]);
			$nombreImg = '';
			
			NombreFileRandom('.'.$handle->file_src_name_ext, FILESUPLOAD."historia".SEPARATOR, $nombreImg);
			$handle->file_new_name_body = $nombreImg;	
			$handle->Process(FILESUPLOAD.SEPARATOR."historia".SEPARATOR);
			if($handle->processed):
			$nombrefoto = $nombreImg.'.'.$handle->file_src_name_ext;
			
			//elimino la foto anterior si hay
			if($cidfoto)
				{
					$fotos = new FotosExtend();
					$fos=$fotos->getFotosByIds($cidfoto);
					foreach($fos as $f)
					{
						@unlink(FILESUPLOAD.'historia'.SEPARATOR.$f->g('nombrearchivo'));	
					}
					$fotos->eliminagrupo($cidfoto);
				}
			
			
			$fotos= new FotosExtend();
			$fotos->setNombrearchivo($nombrefoto);
			$fotos->setTipofoto($tipofoto);
			$fotos->setIdext($cid);
			$fotos->Save();
			
			endif;
			} 

			break;
		}
		
		case "savehistorylangs":
		{
			$com=array();
			$com["message"]=$lang->g('ERROR_PROCESO');
			$com["clase"]="errormsg";
			
			$cid = $_REQUEST['cid'];
			//elimino todos los idiomas
			$historilang= new HistorylangExtend();
			$historilang->eliminaIdiomas($cid);
			
			$soportados=$_REQUEST['soportado'];
			
			if(count($soportado))
			foreach($soportado as $s)
			{
				$textoIdioma=$_REQUEST['idioma'.$s];
				$historilang= new HistorylangExtend();
				$historilang->setIdhistoria($cid);
				$historilang->setLang($s);
				$historilang->setNombreh($textoIdioma);
				$historilang->Save();
		
			}
			
			$com["message"]=$lang->g('GUARDADO_IDIOMAS_SOPORTE');
			$com["clase"]="goodmsg";

				$idresp="hso";
				$_SESSION['cmessage'.$idresp]=$com["message"];
				$_SESSION['ccase'.$idresp]=$com["clase"];
			
				$retorno="history/edit";
				$flink="sitelink";
				if($_REQUEST['return'])
					$retorno=$_REQUEST['return'];
					
				if($_REQUEST['function'])
					$flink=$_REQUEST['function'];	
				
				header("location:".Url::$flink($retorno,"cid=$cid&idm=".$idresp));	
			break;
			
		}
		
		
		
		case "savetraduceparrafo":
		{
			import("classes.parrafo");
			
			$com=array();
			$com["message"]=$lang->g('ERROR_PROCESO');
			$com["clase"]="errormsg";
			
			$cid = $_REQUEST['cid'];
			$cidh = $_REQUEST['cidh'];
			$clangp = $_REQUEST['langp'];
			
			//busco la historia
			$history= new HistoryExtend();
			$history=$history->getById($cidh);
			
			$ctextop = $_REQUEST['textop'];
			//$ctextop= nl2br($ctextop);
			
			$parrafo= new ParrafolangExtend();
			$parrafo=$parrafo->getByIdLanf($cid,$clangp);
			$parrafo->setLang($clangp);
			$parrafo->setTexto($ctextop);
			$parrafo->setParrafo($cid);
			
			if($parrafo->save())
			{
				//salvo las oraciones
				$cantoraciones= $_REQUEST['cantoraciones'];
				
				$ora= new OracionExtend();
				$ora->deleteOraciones($cid,$clangp);
				
				for($i=1;$i<=$cantoraciones;$i++)
				{
					//voy insertando las oraciones
					$ora= new OracionExtend();
					$ora->setIdparrafo($cid);
					$ora->setLang($clangp);
					$ora->setTexto($_REQUEST["oracion$i"]);
					$salto=$_REQUEST["saltooracion$i"];
					if(!$salto)
					{
						$salto=0;
					}
					$ora->setSalto($salto);
					$ora->setNumero($i);
					$ora->Save();	
				}
			}
			
			$com["message"]=$lang->g('GUARDADO_CORRECTO');
			$com["clase"]="goodmsg";

				$idresp="prf";
				$_SESSION['cmessage'.$idresp]=$com["message"];
				$_SESSION['ccase'.$idresp]=$com["clase"];
			
				$retorno="parrafo/listado";
				$flink="sitelink";
				if($_REQUEST['return'])
					$retorno=$_REQUEST['return'];
					
				if($_REQUEST['function'])
					$flink=$_REQUEST['function'];	
				
				//header("location:".Url::$flink($retorno,"cid=$cid&idm=".$idresp));	
			break;
			
		}
		
		case "saveparrafo":
		{
			import("classes.parrafo");
			
			$com=array();
			$com["message"]=$lang->g('ERROR_PROCESO');
			$com["clase"]="errormsg";
			
			$cid = $_REQUEST['cid'];
			$cidh = $_REQUEST['cidh'];
			
			//busco la historia
			$history= new HistoryExtend();
			$history=$history->getById($cidh);
			
			
			
			$ctextop = $_REQUEST['textop'];
			//$ctextop= nl2br($ctextop);
			
			
			//si el parrafo es nuevo genero las oraciones, y guardo el parrafo
			if(!$cid)
			{
				//guardo el parrafo como nuevo
				$parrafo= new ParrafoExtend();
				$parrafo->setTexto($ctextop);
				$parrafo->setIdhistoria($cidh);
				$ctextop=str_replace("\n","*@*",$ctextop);
				
				if($parrafo->save())
				{
					//genero las oraciones para guardarlas
					$oraciones=Parrafoc::generaoraciones($ctextop);
					
					$cidparrafo=$parrafo->getPkId();
					
					foreach($oraciones as $num=>$o)
					{
						//voy insertando las oraciones
						$ora= new OracionExtend();
						$ora->setIdparrafo($cidparrafo);
						$ora->setLang($history->g('idiomaref'));
						$ora->setTexto($o["oracion"]);
						$ora->setSalto($o["salto"]);
						$ora->setNumero($num);
						$ora->Save();					
					}
					
				}
				
			}
			else
			{
				//no es nuevo
				//regenero el parrafo, elimino las oraciones y las vuelvo a meter
				$parrafo= new ParrafoExtend();
				$parrafo->setTexto($ctextop);
				$parrafo->setPkId($cid);
				$ctextop=str_replace("\n","*@*",$ctextop);
				
				
				if($parrafo->save())
				{
					//genero las oraciones para guardarlas
					$oraciones=Parrafoc::generaoraciones($ctextop);
	
					$ora= new OracionExtend();
					$ora->deleteOraciones($cid,$history->g('idiomaref'));
	
					foreach($oraciones as $num=>$o)
					{
						//voy insertando las oraciones
						$ora= new OracionExtend();
						$ora->setIdparrafo($cid);
					
						$ora->setLang($history->g('idiomaref'));
						$ora->setTexto($o["oracion"]);
						$ora->setSalto($o["salto"]);
						$ora->setNumero($num);
						$ora->Save();					
					}
					
				}
				
				
				
			}
	
			
			$com["message"]=$lang->g('GUARDADO_CORRECTO');
			$com["clase"]="goodmsg";

				$idresp="prf";
				$_SESSION['cmessage'.$idresp]=$com["message"];
				$_SESSION['ccase'.$idresp]=$com["clase"];
			
				$retorno="parrafo/edit";
				$flink="sitelink";
				if($_REQUEST['return'])
					$retorno=$_REQUEST['return'];
					
				if($_REQUEST['function'])
					$flink=$_REQUEST['function'];	
				
				//header("location:".Url::$flink($retorno,"cid=$cid&idm=".$idresp));	
			break;
			
		}
		
		
	
		
	}
?>