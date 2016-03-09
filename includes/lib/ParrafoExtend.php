<?php
    
      class ParrafoExtend extends Parrafo
      {
        public function getParrafos($history,$langdefect,$orden="",$campo="",$limit="")
		{
			 $and=array();
			 
			  $and[]="idhistoria=$history";
			 
			 if($nombre)
			 $and[]="nombre like '%$nombre%'";
			 
			 if($landdefect)
			  $and[]="idiomaref='$landdefect'";
			
			 if($and[0])
			 {
				 $and=implode(" and ",$and);
				 $and=" where ".$and;
			 }
			 else
			 $and="";
			 
			 $elorden="";
			 if($campo)
			 { 
			 $elorden="order by $campo $orden";
			 }
			 

			 $query="select SQL_CALC_FOUND_ROWS  p.*, count(*) as cantoraciones from parrafo as p left join oracion as o on o.idparrafo=p.id and o.lang='$langdefect' $and group by p.id $elorden  $limit";
			 
		
			 		 
			 return $this->Select($query);
		}
      }
    