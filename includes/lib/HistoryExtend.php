<?php
    
      class HistoryExtend extends History
      {
       	public function getHistorias($nombre="",$landdefect="",$orden,$campo,$limit="")
		{
			 $and=array();
			 
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
			 
			
			 
			 $query="select SQL_CALC_FOUND_ROWS  h.*, f.nombrearchivo, f.idfoto from history as h left join fotos as f on f.tipofoto=1 and f.idext=h.id  $and $elorden $limit";
			 		 
			 return $this->Select($query);
		}
		
		public function getHistoria($idhistoria)
		{
			 $query="select SQL_CALC_FOUND_ROWS  h.*, f.nombrearchivo, f.idfoto from history as h left join fotos as f on f.tipofoto=1 and f.idext=h.id  where h.id=$idhistoria $elorden $limit";
			 
	
			 
			 return $this->Select($query);
		}
      }
    