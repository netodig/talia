<?php
    
      class CodTiposExtend extends CodTipos
      {		 
		 public function getTipos($id,$cnombre="",$orden="asc",$campo="",$limit="")
		 {
			 	
			 $and=array();
			 if($cnombre)
			 $and[]="nombre like '%$cnombre%'";
			 
			 if($and[0])
			 {
				 $and=implode(" and ",$and);
				 $and=" and ".$and;
			 }
			 else
			 $and="";	
				
			 $elorden="order by orden";
			 if($campo)
			 $elorden="order by $campo $orden";
			 
			 
			 $query="select SQL_CALC_FOUND_ROWS * from cod_tipos as c where tipocod=$id $and $elorden $limit";
			 
 
			 return $this->Select($query);
		 }
          public function getTiposHijos($id,$limit="")
		 {
			 $query="select SQL_CALC_FOUND_ROWS * from cod_tipos as c where idpadre=$id order by orden $limit";
                         
			 return $this->Select($query);
		 }
          public function getTiposGerarq($id,$tipocod,$nombre="",$orden="ASC",$campo="",$limit="")
		 {
			 $and=array();
			 if($nombre)
			 $and[]="nombre like '%$nombre%'";
			 
			 if($and[0])
			 {
				 $and=implode(" and ",$and);
				 $and=" and ".$and;
			 }
			 else
			 $and="";
			 
			 $elorden="order by orden ASC";
			 if($campo)
			 $elorden="order by $campo $orden";

			 $query="select SQL_CALC_FOUND_ROWS c.*, trad.traduccion from cod_tipos as c left join traduccion as trad on trad.idobject=c.id and trad.tabla='cod_tipos' and idiomat='".ELIDIOMA."' where tipocod=$tipocod and idpadre=$id $and $elorden $limit";
			 
              return $this->Select($query);
						 
			 
		 }
		 public function getListTipos($id,$limit="",$seleccionar="")
		 {
			 $a = $this->getTipos($id,$limit="");
			  
			  $c= array();
			  if($seleccionar)
			  $c[""]=$seleccionar;
			  foreach($a as $co)
			  {
				  $c[$co->g('id')]=$co->g('nombre');
			  }
			  
			  return $c;
		 }
		 
		 public function getLTipoGerarquico($id,$idpadre="-1",$seleccionar="Seleccionar", $limit="")
		 {
			 
			 $query="select SQL_CALC_FOUND_ROWS * from cod_tipos as c where idpadre=$idpadre and tipocod=$id order by orden $limit";
			 $a = $this->Select($query);
			  
			 $c= array();
			 if($seleccionar)
			 $c[""]=$seleccionar;
			 
			 foreach($a as $co)
			 {
				$c[$co->g('id')]=$co->g('nombre');
			 }
			  
			  return $c;
		 }
                 
      }
    