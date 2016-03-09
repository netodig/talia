<?php
    
      class PmodulosTaskExtend extends PmodulosTask
      {
         	public function getmodulos($cid)
			{
				$query="select SQL_CALC_FOUND_ROWS * from pmodulos_task as p where idmodulo=$cid  $limit";
				
				return $this->Select($query);
			}
			
			public function getModulePermisos($idperfil, $idmodule, $tipo=1)
			{
				$query="select p.*, pp.id as idpermiso from pmodulos_task as p left join perfil_permisos as pp on pp.idperfil=$idperfil and p.idmodulo=pp.idmodule and pp.idtask=p.id where p.idmodulo=$idmodule and tipo=$tipo $limit";
				

				return $this->Select($query);
			}
			
			public function deletePermisos($idperfil)
			{
				$query="delete from perfil_permisos where idperfil=$idperfil";
				$this->Select($query);
			}
			
			public function gettaskes()
			{
				$query="select * from pmodulos_task as p";
				

				return $this->Select($query);
			}
			
			public function getTaskModule($idperfil,$idmodulo)
			{
				$query="select p.* from pmodulos_task as p inner join perfil_permisos as pp on pp.idperfil=$idperfil and p.idmodulo=pp.idmodule and pp.idtask=p.id where p.idmodulo=$idmodulo $limit";
				
				return $this->Select($query);
			}
			
      }
    