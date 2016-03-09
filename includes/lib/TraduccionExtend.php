<?php
    
      class TraduccionExtend extends Traduccion
      {
		 
		 public function getTablas()
		 {
			 $query="show tables";
			 
			 return $this->Select($query);
		 }
		 
		  public function getTablaDes($tabla)
		 {
			 $query="describe $tabla";
			 
			 return $this->Select($query);
		 }
		 
		 public function getOriginal($tabla,$id,$campoid="")
		 {
			//fix para idrest
			$subquery="";
			if(defined("ID_REST"))
			$subquery=" and t.idrest=".ID_REST;
			 
			 $query="select * from $tabla as t where $campoid=$id $subquery";
	

			  return $this->Select($query);
			 
		 }
		 
		 public function getCamposTabla($tabla)
		 {
			 $query="select * from traduccion_tabla where tabla='$tabla' order by campo";
			 
			 return $this->Select($query);
		 }
		 
		 public function limpiarAlEliminar($idobject,$tabla)
		 {
			 $query="delete from traduccion where idobject=$idobject and tabla='$tabla'";
			 
			 return $this->Select($query);
		 }
      }
    