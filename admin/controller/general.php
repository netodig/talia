<?php
import('classes.mail.phpmailer');
import('classes.classmail');

$com= array();
$task=$_REQUEST['task'];
function getNivel($idCod)
{
    $nivel=0;
    $cod = new CodTiposExtend();
    $cod = $cod->getById($idCod);
    if($cod)
    {
        $nivel=$cod->g('nivel');
    }
    return $nivel;
}
switch($task)
	{	
		
		
		case "savecod":
		{
			import("upload");
			
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			
			$tipocod = $_REQUEST["tipocod"];
			$cid = $_REQUEST["cid"];
			$cnombre = $_REQUEST["nombre"];
                        $calias = $_REQUEST["alias"];
                        $cnivel = getNivel($cid);
			$corden = $_REQUEST["orden"];
                        $cidpadre=$_REQUEST["idpadre"];
			if(!$corden)
			$corden=0;

			$cod = new CodTiposExtend();
			$cod->setPkId($cid);	
			$cod->setNombre($cnombre);
			$cod->setTipocod($tipocod);
			$cod->setOrden($corden);
                        $cod->setAlias($calias); 
                        if($cidpadre)
                        {
                            $cnivel = getNivel($cidpadre)+1;
                            $cod->setNivel($cnivel);
                            $cod->setIdpadre($cidpadre);
                        }
 
			if($cod->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$cod->getPkId();
			}

			break;
		}
		
		
	
		case "savefotos":
		{
			import("upload");
			
			$id= $_REQUEST['id'];
			$tipo= $_REQUEST['tipo'];
			$idtext2= $_REQUEST['idtext2'];
			
			$carpeta= $_REQUEST['carpeta'];
			
			$fotosguardadas=0;
		  for($i=1;$i<9;$i++)
		  {

			  if($_FILES["foto$i"])
			  {
				  $nombrefoto ="";
				  $handle = new upload($_FILES["foto$i"]);
				  $nombreImg = '';
				  
				  NombreFileRandom('.'.$handle->file_src_name_ext, FILESUPLOAD.$carpeta.SEPARATOR, $nombreImg);
				
				  $handle->file_new_name_body = $nombreImg;	
				  $handle->Process(FILESUPLOAD.$carpeta.SEPARATOR);
				  if($handle->processed):
				  
				  $nombrefoto = $nombreImg.'.'.$handle->file_src_name_ext;
				  //inserto la foto
				  
				  	  $f= new FotosExtend();
					  $f->setNombrearchivo($nombrefoto);
					  $f->setTipofoto($tipo);
					  $f->setIdext($id);
					  $f->setPie($_REQUEST["pie$i"]);
					  $orden=$_REQUEST["orden$i"];
					  if(!$orden)
					  $orden=1;
					  
					  if(is_nan($orden))
					  $orden=1;
					  
					  $f->setOrden($orden);
					  $f->setIdtext2($idtext2);
					  $f->Save();
					  $fotosguardadas++;
				  endif;
			  }
			  
			  if($fotosguardadas)
			  {
				  $caso=1;
				  $message="Se han guardado las $fotosguardadas fotos correctamente";
			  }
		  }
			break;
		}
		
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
				header("location:".Url::adminlsolo("index"));
			}
			else
			{
				$com["message"]="Usuario/pass incorrecto";
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
		
		//emails
			case "saveemailconfig":
		{
			$com["message"]="Ocurrió un error y no se guardó la informacion";
			$com["clase"]="error";
			
			
			$cid=$_REQUEST['cid'];
			
			$cvariables= $_REQUEST['variables'];
			$ccode= $_REQUEST['code'];
			$cnombre= $_REQUEST['nombre'];
			$cdescripcion= $_REQUEST['descripcion'];

			$email= new EmailsPlantillaExtend();
			$email->setPkId($cid);
			$email->setNombre($cnombre);
			$email->setVariables($cvariables);
			$email->setCode($ccode);
			$email->setDescripcion($cdescripcion);
			
			if($email->Save())
			{
			$com["message"]="Se ha guardado la información correctamente.";
			$com["clase"]="goodmsg";
			
			}
			break;
		}
		
		case "saveemail":
		{
			$com["message"]="Ocurrió un error y no se guardó la informacion";
			$com["clase"]="error";
			
			
			$cid=$_REQUEST['cid'];
			
			$ctitulo= $_REQUEST['titulo'];
			$ctexto= $_REQUEST['texto'];
			$cemailde= $_REQUEST['emailde'];

			$email= new EmailsExtend();
			$email->setPkId($cid);
			$email->setTitulo($ctitulo);
			$email->setTexto($ctexto);
			$email->setEmailde($cemailde);
			
			if($email->Save())
			{
			$com["message"]="Se ha guardado la información correctamente.";
			$com["clase"]="goodmsg";
			
			}
			break;
		}
		// termina emails
		
		//seo
		
		case "saveseoconfig":
		{
			$com["message"]="Ocurrió un error y no se guardó la informacion";
			$com["clase"]="error";
			
			
			$cid=$_REQUEST['cid'];
			
			$cvariables= $_REQUEST['variables'];
			$cmodulo= $_REQUEST['modulo'];
			$cnombre= $_REQUEST['nombre'];

			$seo= new SeoConfigExtend();
			$seo->setPkId($cid);
			$seo->setNombrepagina($cnombre);
			$seo->setVariables($cvariables);
			$seo->setModule($cmodulo);
			
			if($seo->Save())
			{
			$com["message"]="Se ha guardado la información correctamente.";
			$com["clase"]="goodmsg";
			
			}
			break;
		}
		
		case "savepaginaseo":
		{
			$com["message"]="Ocurrió un error y no se guardó la informacion";
			$com["clase"]="error";
			
			
			$cid=$_REQUEST['cid'];
			
			$ctitulo= $_REQUEST['titulo'];
			$cdescripcion= $_REQUEST['descripcion'];
			$cidtipo= $_REQUEST['cidtipo'];

			$seo= new SeoExtend();
			$seo->setPkId($cid);
			$seo->setTitulo($ctitulo);
			$seo->setDescripcion($cdescripcion);
			$seo->setTipo($cidtipo);
			
			if($seo->Save())
			{
			$com["message"]="Se ha guardado la información correctamente.";
			$com["clase"]="goodmsg";
			
			}
			break;
		}
		//termina seo
		
		//hasta acá son los generales

		
	}
?>