<?php
class Dbo
{
  private $conn;
  private $loadedCodif;
  private $result;
  private $error;
  public function __construct($host, $user, $password, $database, $codif="utf8")
   {
   	 $this->conn = @mysqli_connect($host, $user, $password, $database);	 
     $this->result = NULL;
	 
	 if($this->conn):
	 @mysqli_set_charset($this->conn, $codif);
	 
	 if(!$this->getError()):
	 
	   if (!@mysqli_set_charset($this->conn, $codif)):
             $this->loadedCodif = sprintf("Error loading character set $codif: %s\n", @mysqli_error($this->conn));
           else:
             $this->loadedCodif = sprintf("Current character set: %s\n", @mysqli_character_set_name($this->conn));
	   endif; 	
	   
	 endif;
	 
	 else:
	   $this->error = 'Error: Unable to conect database';
	 endif;
   }
  
  public function setQuery($query){$this->result = @mysqli_query($this->conn, $query);}
  
  public function getLoadedCodif(){return $this->loadedCodif;}
  
  public function affectedRows(){return @mysqli_affected_rows($this->conn);} 	
  
  /*
   * Obtiene el id del registro insertado
   */
  public function getInsertId(){return @mysqli_insert_id($this->conn);}   
  
  /*
   * devuelve una lista de objetos stdClass();
   */
  public function loadObjectList(){return $this->hydrating($this->result);}
  
  /*
   * Metodo para ejecutar un un update o un delete
   */
  public function voidQuery($query){return @mysqli_query($this->conn, $query);}
  
  /*
   * devueve el una tupla de la consulta ejecutada
   */
  public function next_record(){return @mysqli_fetch_array($this->result, MYSQLI_BOTH);}
   
   
   private function hydrating($result)
   {
      $res = array();
	  while($obj = @mysqli_fetch_object($result))
	   $res[] = $obj;	   
          
      @mysqli_free_result($result);      
     return $res;
   }
   
  public function oneRecord($query)
   {
     $obj = mysqli_fetch_object(@mysqli_query($this->conn, $query));
	 return $obj ? $obj : new stdClass();
   }
   
   private function formatQuery($tabla, $columnas = array())
   {
     $r = array();
     foreach($columnas as $k):
	      $r[$k] = "$tabla.$k";
	 endforeach;
	 return $r;
   }
   
   private function getUpdate($tabla, $params, $cond)
   {
     $campos = array_keys($params);	 
	 $fC = $this->formatQuery($tabla, $campos);	
	 $pUp = "";
	 //foreach($campos as $k=>$v):
	 foreach($params as $k=>$v):
	   $v = addslashes($v);
	   if(!$pUp):
	     $pUp = $fC[$k]."='$v'";
	   else:
	     $pUp .= ','.$fC[$k]."='$v'";
	   endif;
	 endforeach;
	 return "update $tabla set $pUp $cond";
   } 

   private function getInsert($tabla, $params)
   {
	 $campos = array_keys($params);
	 $fC = $this->formatQuery($tabla, $campos);
	 $pUp = "";	 
	 $val = array_values($params);	 
	 foreach($val as $k=>$v):
	   $v = addslashes(stripslashes($v));
	   if(!$pUp):
	     $pUp = "'$v'";
	   else:
	     $pUp .= ", '$v'";
	   endif;
	 endforeach;
	 
	 return $insert = "insert into $tabla (".implode(', ',$this->formatQuery($tabla, $campos)).") values ($pUp)";	 	 
   }
   
  public function Save($obj, $tabla, $pk = array())
   {  
      $vars = get_object_vars($obj);	  
	  $cnd = '';
	  $treg = count($vars);
	  $cnt_pk = count($pk);
      if($cnt_pk)
	  {
	     foreach($pk as $k):		
		 if($obj->$k):
		   if(!$cnd)
		     $cnd= " $tabla.$k= ".$obj->$k;
		   else
             $cnd .= " and $tabla.$k= ".$obj->$k;
		 endif;	 
		 endforeach;
		
	  }
	  
	  if($cnd):	   
	    $this->voidQuery($this->getUpdate($tabla, $vars, "where $cnd"));		
	  else:
	    $this->voidQuery($this->getInsert($tabla, $vars));
		if($cnt_pk == 1):
		  list($k, $v) = $pk;		  
                  $idins = $this->getInsertId();
		  if($idins)
		   $obj->$k = $idins;		  
		endif; 
	  endif;
	  
	 return $this->getError() == '';
   }
   
   public function getError()
   {
     $error = @mysqli_error($this->conn);
     if($error)
       $this->error = $error;
	   
     return $this->error;
   } 
}
?>