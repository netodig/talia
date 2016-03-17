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
			 

			 $query="select SQL_CALC_FOUND_ROWS  p.*, count(*) as cantoraciones,GROUP_CONCAT(distinct(pl.lang)) as traducidos from parrafo as p left join oracion as o on o.idparrafo=p.id and o.lang='$langdefect' left join parrafolang as pl on pl.parrafo=p.id $and group by p.id $elorden  $limit";
			 	 
			 return $this->Select($query);
		}
		
		public function getLangsSintraducir($idparrafo)
		{
			$query="select * from historylang as hl inner join parrafo as p on p.idhistoria=hl.idhistoria and p.id=$idparrafo where hl.lang not in(select lang from parrafolang as pll where pll.parrafo=$idparrafo) ";
			
			return $this->Select($query);
		}
      }
    