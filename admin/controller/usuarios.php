<?php
import('classes.mail.phpmailer');
import('classes.classmail');

$com= array();
$task=$_REQUEST['task'];

switch($task)
	{	
		case "saveruser":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			

			$cnombre = $_REQUEST['nombre'];
			$cclave = $_REQUEST['clave'];
			$cid = $_REQUEST["cid"];
			$cemail = $_REQUEST["email"];
			$tipo = $_REQUEST["tipo"];
			
			$capellidos = $_REQUEST['apellidos'];
			$cdni = $_REQUEST['dni'];
			$cnombrereal = $_REQUEST['nombrereal'];
			

			$user = new UserinterExtend();
			$namuser= $user->getLoginName($cnombre,$cid);
			
			if(!$namuser[0])
			{
			$user->setPkId($cid);	

			$user->setName($cnombre);
			$user->setClave($cclave);
			$user->setEmail($cemail);
			$user->setTipo($tipo);
			
			$user->setNombre($cnombrereal);
			$user->setApellidos($capellidos);
			$user->setDni($cdni);
			
			if($user->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$user->getPkId();
			}
			}
			else
			{
				$com["message"]="Ya existe un usuario con ese nombre";
			}
			
			break;
			
		}
	
		case "saveperfil":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			
			$idnuevo=false;
			
			$cid= $_REQUEST['cid'];
			if(!$cid)
			$idnuevo=true;
			
			$cnombre = $_REQUEST['nombre'];
			
			$perfil = new PerfilesExtend();
			$perfil->setPkId($cid);
			
			$perfil->setNombre($cnombre);
			
			if($perfil->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$perfil->getPkId();
				
				if(!$idnuevo)
				{
				//veo si tiene permisos, los borro e inserto
				$taskes= new PmodulosTaskExtend();
				$taskes->deletePermisos($cid);
				
				$tareas=$taskes->gettaskes();
				
				foreach($tareas as $t)
					{
						if($_REQUEST['permiso'.$t->g('id')])
						{
							//agrego el permiso
							$permiso= new PerfilPermisosExtend();
							$permiso->setIdmodule($t->g('idmodulo'));
							$permiso->setIdtask($t->g('id'));
							$permiso->setIdperfil($cid);
							$permiso->Save();
						}
					}
				
				}
				
				
			}
			
			break;
			
		}
		
		case "savemodulo":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			

			$cid= $_REQUEST['cid'];
			$cnombre = $_REQUEST['nombre'];
			$cacceso = $_REQUEST['acceso'];
			$ctipo = $_REQUEST['tipo'];
			
			$modulo = new PmodulosExtend();
			$modulo->setPkId($cid);
			
			$modulo->setNombre($cnombre);
			$modulo->setAcceso($cacceso);
			$modulo->setTipo($ctipo);
			
			if($modulo->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$modulo->getPkId();
			}
			
			break;
			
		}
		
		case "savetaremodulo":
		{
			$com=array();
			$com["message"]="Ocurrió un error y no se guardaron los datos";
			$com["clase"]="errormsg";
			

			$cid= $_REQUEST['cid'];
			$cnombre = $_REQUEST['nombre'];
			$ctask = $_REQUEST['taske'];
			$ctipo = $_REQUEST['tipo'];
			$cidmodulo = $_REQUEST['idmodulo'];
			
			$tarea = new PmodulosTaskExtend();
			$tarea->setPkId($cid);
			
			$tarea->setIdmodulo($cidmodulo);
			$tarea->setNombre($cnombre);
			$tarea->setTask($ctask);
			$tarea->setTipo($ctipo);
			
			if($tarea->Save())
			{
				$com["message"]="Se ha guardado la información correctamente";
				$com["clase"]="goodmsg";
				$cid =$_REQUEST['cid']=$tarea->getPkId();
			}
			
			break;
			
		}
		
		
		
		
		
	}
?>