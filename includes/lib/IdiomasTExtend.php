<?php
    
      class IdiomasTExtend extends IdiomasT
      {
         public function getIdiomas($limit="")
         {
            $query="select SQL_CALC_FOUND_ROWS * from idiomas_t as it where it.activo=1  $limit";
            return $this->Select($query);
		 }
		 
		 public function getIdiomasAdmin($limit="")
         {
            $query="select SQL_CALC_FOUND_ROWS * from idiomas_t as it $limit";
            return $this->Select($query);
		 }
         public function getListIdiomas($primero)
         {
            $idioma = $this->getIdiomas();
            $result= array();
			if($primero)
			 $result[""]= $primero;
			 
            foreach($idioma as $i)
            {
			$result[$i->g('abv')]=$i->g('nombre');
            }
			  
            return $result;
	 }
      }
    