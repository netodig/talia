<?php
    
      class TipoEmpresasExtend extends TipoEmpresas
      {
         public function g($id){return $this->get($id);}
		 
		 public function getTipoEmpresas()
		  {
			  $tipo_empresas = $this->Select();
			  
			  $c= array();
			  foreach($tipo_empresas as $co)
			  {
				  $c[$co->g('idtipo')]=$co->g('nombre');
			  }
			  
			  return $c;
		  }
		  
      }
    	