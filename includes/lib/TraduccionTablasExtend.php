<?php
    
      class TraduccionTablasExtend extends TraduccionTablas
      {
     
		 
		public function Deltabla($tabla)
		{
			$query="delete from traduccion_tablas";
			
			$this->Select($query);
		} 
		
		public function getElementos()
		{
			$query="select * from traduccion_tablas as tt inner join traduccion_tabla as tta on tta.tabla=tt.nombretabla";
			
			 return $this->Select($query);
		}
		
		public function getDatosTabla($tabla,$idioma,$campoid="id",$orderby="",$subquery="")
		{
			
			//fix para idrest
			if($subquery)
			{
			$subquery="where $subquery";	
			}
			/*if(defined("ID_REST"))
			$subquery=" where t.idrest=".ID_REST;*/
			
			if($orderby)
			$orderby="order by $orderby";
			
			
			$query="select t.*, ta.id as idtrad ,ta.idobject,ta.traduccion from $tabla as t left join traduccion as ta on ta.idobject=t.$campoid and tabla='$tabla' and idiomat='$idioma' $subquery $orderby";
			

			 return $this->Select($query);
		}
		
		public function getDataTable($tabla)
		{
			 $query="select * from traduccion_tablas where nombretabla='$tabla'";
			 
			 return $this->Select($query);
		}
		
		public function getTablasDesc()
		 {
			 $query="select * from traduccion_tablas";
			 
			 return $this->Select($query);
		 }
      }
    