<?php
    
      class ParrafolangExtend extends Parrafolang
      {
        public function getByIdLanf($id,$lang)
		{
			$query="select * from parrafolang as pf where pf.parrafo=$id and pf.lang='$lang'";
			
			
			$parraf= $this->Select($query);
			
			if($parraf[0])
			$parraf=$parraf[0];
			else
			$parraf= new ParrafolangExtend();
			
			return $parraf;
		}
      }
    