<?php
    
      class SeoConfigExtend extends SeoConfig
      {
        	public function getListado($limit="")
			{
				$query="select * from seo_config $limit";
				
				return $this->Select($query);
			}
			
			public function getListadoPaginas($limit="")
			{
				$query="select s.*, ss.titulo, ss.descripcion, ss.id as idss from seo_config as s left join seo as ss on ss.tipo=s.id $limit";
				
				return $this->Select($query);
			}
			
			public function getPagina($idtipo)
			{
				$query="select s.*, ss.titulo, ss.descripcion, ss.id as idss from seo_config as s left join seo as ss on ss.tipo=s.id where s.id=$idtipo";
				
				return $this->Select($query);
			}
      }
    