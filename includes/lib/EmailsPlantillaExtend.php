<?php
    
      class EmailsPlantillaExtend extends EmailsPlantilla
      {
       		 public function getListado($limit="")
			{
				$query="select * from emails_plantilla $limit";
				
				return $this->Select($query);
			}
			
      }
    