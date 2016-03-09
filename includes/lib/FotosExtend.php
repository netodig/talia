<?php
    
      class FotosExtend extends Fotos
      {
       
		 
		 public function getfotos($idtext, $tipo,$limit=0)
		 {
			 $limite="";
			 if($limit)
			 $limite="order by rand() limit 0,$limit"; 
			
			 $query="select * from fotos where tipofoto=$tipo and idext=$idtext $limite";
			 
			 return $this->Select($query);
		 }
		 
		 public function getfotosGen($idtext, $tipo,$limit=0,$idtext2=0)
		 {
			 $limite="";
			 if($limit)
			 $limite="order by rand() limit 0,$limit"; 
			 
			 $and=array();
			  
			 if($idtext)
				 $and[]="idext=$idtext";
				 
			  if($idtext2)
			   $and[]="idtext2=$idtext2";
			   
			 if($and[0])
			 $and=implode(" and ",$and);
			 else
			 $and="";
			
			 $query="select * from fotos where tipofoto=$tipo $and $limite";
			 
			 
			 return $this->Select($query);
		 }
		 
		 public function getfotosGen2($idtext, $tipo,$limit=0)
		 {
			 $limite="";
			 if($limit)
			 $limite="order by rand() limit 0,$limit"; 
			 
			 $and=array();
			  
			 if($idtext)
				 $and[]="idext in($idtext)";
				 
			  if($idtext2)
			   $and[]="idtext2=$idtext2";
			   
			 if($and[0])
			 $and=" and ".implode(" and ",$and);
			 else
			 $and="";
			
			 $query="select * from fotos where tipofoto=$tipo $and $limite";
			 
			 
			 return $this->Select($query);
		 }
		 
		 
		  public function getFotos2($tipo, $idext,$idtext2="" ,$tabla="",$imgprincipal="")
			{

				$and="";
				if($idtext2)
				$and="and idtext2=$idtext2";
				$query="select * from fotos where tipofoto=$tipo and idext=$idext $and order by orden";
				
				if($tabla)
					$query="select f.* from fotos as f left join $tabla as t on t.$imgprincipal=f.idfoto where tipofoto=$tipo and idext=$idext $and order by t.$imgprincipal DESC, f.orden ASC";
			
					
					
					
				return $this->Select($query);
			}
				public function getFotosByIds($ids)
			{
				
				$query="select * from fotos where idfoto in ($ids)";
				

				
				
				return $this->Select($query);
			}
			 public function eliminagrupo($arrelimina)
		 {
			 $query="delete from fotos where idfoto in($arrelimina)";

			 $this->Select($query);
		 }
      }
    