<?php
    
      class OracionExtend extends Oracion
      {
       		public function getOraciones($parrafo, $lang)
			{
				$query="select * from oracion as o where o.idparrafo=$parrafo and lang='$lang'";
				
				return $this->Select($query);
			}
			
			public function deleteOraciones($parrafo, $lang)
			{
				$query="delete from oracion where idparrafo=$parrafo and lang='$lang'";
				
				return $this->Select($query);
			}
			
      }
    