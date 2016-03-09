<?php
    
      class PerfilesExtend extends Perfiles
      {
       		public function getperfiles($limit="")
			{
				$query="select SQL_CALC_FOUND_ROWS * from perfiles $limit";
				
				return $this->Select($query);
			}
      }
    