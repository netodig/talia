<?php
    
      class HistorylangExtend extends Historylang
      {
         public function getIdiomasSoport($idhist)
		 {
			 $query="select h.*, i.nombre as idioma from historylang as h left join idiomas_t as i on i.abv=h.lang where idhistoria=$idhist";
			 
			 return $this->Select($query);
		 }
		 
		 public function getIdiomasSoportPosible($idhistory,$langex)
		 {
			 $query="select i.nombre as idioma, i.abv, h.* from idiomas_t as i left join historylang as h on h.lang=i.abv and h.idhistoria=$idhistory where i.abv<>'$langex'";
			 
			 return $this->Select($query);
		 }
		 
		 public function eliminaIdiomas($idhistory)
		 {
			 $this->Select("delete from historylang where idhistoria=$idhistory");
		 }
		 
      }
    