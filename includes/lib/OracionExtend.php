<?php
    
      class OracionExtend extends Oracion
      {
       		public function getOraciones($parrafo, $lang)
			{
				$query="select * from oracion as o where o.idparrafo=$parrafo and lang='$lang'";
				
				return $this->Select($query);
			}
			
			public function getOracionesTrans($parrafo, $lang, $langtrad)
			{
				$query="select o.*, ol.lang as langol, ol.texto as textool, ol.salto as saltool from oracion as o left join oracion as ol on o.idparrafo=ol.idparrafo and ol.lang='$langtrad' and ol.numero=o.numero where o.idparrafo=$parrafo and o.lang='$lang'";
				

				return $this->Select($query);
			}
			
			
			public function deleteOraciones($parrafo, $lang)
			{
				$query="delete from oracion where idparrafo=$parrafo and lang='$lang'";
				
				return $this->Select($query);
			}
			
      }
    