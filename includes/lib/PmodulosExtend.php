<?php
    
      class PmodulosExtend extends Pmodulos
      {
        	public function getmodulos($limit="")
			{
				$query="select SQL_CALC_FOUND_ROWS * from pmodulos $limit";
				
				return $this->Select($query);
			}
			
			public function getModulesPermiso($idperfil,$tipo=1)
			{
				$query="select pm.* from perfil_permisos as pp inner join pmodulos as pm on pm.id=pp.idmodule and pm.tipo=$tipo group by pm.id";
			
				return $this->Select($query);
			}
      }
    