<?php
    
      class TraduccionTablaExtend extends TraduccionTabla
      { 
	
		 
		public function Deltabla($tabla)
		{
			$query="delete from traduccion_tabla where tabla='$tabla'";
			
			$this->Select($query);
		} 
		
      }
    