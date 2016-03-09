<?php
    class Contenido
    {
       var $conn;       
       var $Field;
       var $auxRecords;	   
       var $formatFields;
       var $listPk;
       var $listPkFormat;
       var $listModifiedField;
       var $listField;
 
       public function Contenido()
       {
          $this->conn = JFactory::getDbo();          
          $this->Field = array(); 
          //aqui se van a guardar los formatos de los campos
          $this->formatFields = array('idPagina'=>"`contenido`.`idPagina` = %s", 'idModulo'=>"`contenido`.`idModulo` = %s", 'textContenido'=>"`contenido`.`textContenido` = '%s'");
          //listado de llaves primarias
          $this->listPk = array();
          //formato de las llaves primarias
          $this->listPkFormat = array("idContenido"=>"`contenido`.`idContenido` = %s");
          //listado de campos que contiene la tabla Contenido
          $this->listField = array("idContenido"=>"idContenido", "idPagina"=>"idPagina", "idModulo"=>"idModulo", "textContenido"=>"textContenido");
          //listado de campos que se modifican a traves del uso de la clase
          $this->listModifiedField = array();		  
          
          $this->Field["idContenido"] = 0;
          $this->Field["idPagina"] = 0;
          $this->Field["idModulo"] = 0;
          $this->Field["textContenido"] = "";		  
       }
            
       
       public function Save()
       {
          
     	  if($this->listPk["idContenido"])
     	  { 
			$this->conn->voidQuery($this->Update());
     	  }
     	  else
     	  {     	    
			$this->conn->voidQuery($this->Insert());
            if($this->conn->getInsertId())
     	    $this->listPk["idContenido"] = $this->conn->getInsertId();     	         	
     	  }
		  return $this->conn->getError() == "";     	  
     	
       }
       
       public function Insert()
       {
          return $query = sprintf("insert into `contenido` (`contenido`.`idPagina`, `contenido`.`idModulo`, `contenido`.`textContenido`) VALUES(%s, %s, '%s')", $this->Field["idPagina"], $this->Field["idModulo"], $this->Field["textContenido"]);
       }
       
       
       public function Update()
       {  
          //obtiene los campos a actualizar  
       	  $intersecUpdateField = array_intersect_key($this->formatFields, $this->listModifiedField);      
       	  //obtiene las llaves primarias
       	  //$intersecPk = array_intersect_key($this->formatFields, $this->listPk);
       	  
       	  //se obtienen los valores
       	  
       	  foreach ($intersecUpdateField as $key=>$value)       	  
       	   $intersecUpdateField[$key] = str_replace("%s", $this->scapingData($this->Field[$key]), $intersecUpdateField[$key]);
       	  
       	  $intersecPk = array();
       	  foreach ($this->listPk as $clave=>$valor)
       	   $intersecPk[$clave] = str_replace("%s", $this->scapingData($this->listPk[$clave]), $this->listPkFormat[$clave]);
       	   
       	  return $query = "update `contenido` set ".implode(", ", $intersecUpdateField)." where ".implode(" and ", $intersecPk);
       }
       
       public function Delete()
       {
          $query =sprintf("delete from `contenido` where `contenido`.`idContenido` = %s", $this->Field["idContenido"]);
          return $this->conn->voidQuery($query);
       }
       
       public function Select($query = "")
       {
          if($query == "")          
            $query = "select * from `contenido`";             
          
          return $this->Hydrating($query);          
       }
       
       /**
       * Este metodo devuelve un array con el objeto de tipo Contenido
       * dado un ID determinado
       */
       public function getContenidoById($IdContenido)
       {
         return $this->SelectConditional(sprintf("where `contenido`.`idContenido` = %s", $IdContenido));
       }
	   
	   /**
       * Este metodo devuelve un array con el objeto de tipo Contenido
       * dado un ID determinado
       */
       public function getByIdInter($IdContenido)
       {
         return $this->SelectConditional(sprintf("where `contenido`.`idContenido` = %s", $IdContenido));
       }
	   
	    public function getById($IdContenido)
       {
         $obj=$this->getByIdInter($IdContenido);
		 
		 return $obj[0];
       }
          
	   	
	     
		     
       /**
       * por el parametro $condition se pasan condiciones SQL para hacer un select mas especifico
       * Ejemplo
       * Where usuario = "pepe" and edad = "25"
       */
       public function SelectConditional($condition)
       {
         $query = "select SQL_CALC_FOUND_ROWS `contenido`.`idContenido`, `contenido`.`idPagina`, `contenido`.`idModulo`, `contenido`.`textContenido` from `contenido` $condition";
          return $this->Hydrating($query);
       }
	   
	   /**
	   * @param string $query consulta que se desea ejecutar, este método ejecuta la consulta
	   * @return int devuelve la cantidad de registros afeectados
	   */
	   public function voidQuery($query)
	   {
		   $this->conn->voidQuery($query);
		   return $this->conn->affectedRows();
	   }
     
       
       /**
       * funcion para ejecutar funciones de agregado xes decir funciones que devuelven un solo valor 
       * parámetro $elemento puede recibir operador valido de SQL EJ: * o el nombre de un campo
       * parámetro $fAgregado este es el nombre de la funcion de agregado que se quiere usar
       * EJ: COUNT, SUM, AVG, MIN, MAX  
       * parámetro $condition admite una condición "where" u otra que sea válida       
       * esta devuelve el valor del resultado de la consulta     
       */
       public function functionsAgregate($elemento, $fAgregado, $condition)
       {
          $query = "select $fAgregado($elemento) as result from `contenido` $condition";
     	  
     	  return $this->conn->oneRecord($query)->result;
     	
       }
  
	  
	  /**
      * Este método devuelve una lista de objetos del tipo Ofertas
      */
      private function Hydrating($query)
      {         
         $this->conn->setQuery($query);
     	 $list = array();
     	
		    $row = array();
     	    while($row = $this->conn->next_record())
     	    {
     	      $object = new  ContenidoExtend();			  
     	      $object->Field = $row;
     	      //obtiene todas la clave/valores que sean iguales a los campos de la tabla Contenido
     	      $inteseccionClave = array_intersect_key($row, $this->listField);
     	      
     	      //obtengo todas la claves de los campos cargados para especificar que pueden ser modificados
     	      $keys = array_keys($inteseccionClave);
     	      
     	      //pone todos los campos que se han modificado a true
     	      $object->listModifiedField = array_fill_keys($keys, true);
			  
			  //obtengo las llaves primarias cargadas
			  $object->listPk = array_intersect_key($row, $this->listPkFormat);	
     	      
     	      $list[] = $object;
     	    }
     	     	
     	 return $list; 
      }
      
      /**
      * @param int $startRows indica a partir de donde se van a recuperar los registros
      * @param int $MaxRows indica el total de registros maximos que se van a recuperar
      * Estas 2 variables se utilizan para la paginacion de registros
      */	 
      public function Search($params = array(), $data= array() , $startRows = 0, $maxRows = 10)
    	{
               $cond = array();

               if($params["idContenido"]) $cond[] = "`contenido`.`idContenido`=".$params["idContenido"]; 

                if($params["idPagina"]) $cond[] = "`contenido`.`idPagina`=".$params["idPagina"]; 

                if($params["idModulo"]) $cond[] = "`contenido`.`idModulo`=".$params["idModulo"]; 

                if($params["textContenido"]) $cond[] = "`contenido`.`textContenido`like '%".$params["textContenido"]."%'"; 

                $q = $cond[0] ? "where ".implode(" and ", $cond) : "";

               $limit = $maxRows ? "limit $startRows, $maxRows" : "";

    	   return $this->Select("select SQL_CALC_FOUND_ROWS `contenido`.`idContenido`, `contenido`.`idPagina`, `contenido`.`idModulo`, `contenido`.`textContenido` from `contenido` $q $limit");
    	}
      
      /**      
      * hace un conteo de los resultados totales de la busqueda
      */	
      public function SearchCount($params = array())
    	{
               $cond = array();

               if($params["idContenido"]) $cond[] = "`contenido`.`idContenido`=".$params["idContenido"]; 

                if($params["idPagina"]) $cond[] = "`contenido`.`idPagina`=".$params["idPagina"]; 

                if($params["idModulo"]) $cond[] = "`contenido`.`idModulo`=".$params["idModulo"]; 

                if($params["textContenido"]) $cond[] = "`contenido`.`textContenido`like '%".$params["textContenido"]."%'"; 

                $q = $this->parseParams($cond);


    	   return $this->functionsAgregate("*", "count", $q);
    	}
       
      //addRelation
	  
	  //get de aristides
	   public function g($id,$num="",$post="")
		 {
			 $data=$this->get($id.$post);
			 
			 
			 if($this->get("traduccion$num"))
			 {
				 //cojo el json
				 $json=$this->get("traduccion$num");
				 $json=str_replace("\'","'",$json);	
				 $json=json_decode($json);
				 
				 if($json->$id)
				 {
					$data= $json->$id;
				 }
			 }
			 
			 $data=str_replace("\'","'",$data);
			 return $data;
		 }
		 
      public function getRegistrosCalculados()
      {
        return $this->conn->oneRecord("select found_rows() as cant")->cant;
      }

      public function scapingData($string){return addslashes(stripslashes($string));}
	  
	  protected function parseParams(array $params, $tpQuery = "where"){ return $params[0] ? sprintf(" %s %s ", $tpQuery, implode(" and ", $params)) : ""; }

       
       public function setPkIdContenido($IdContenido)
       {
         $this->listPk["idContenido"] = $this->scapingData($IdContenido);
       }

       public function setIdContenido($IdContenido)
       {
         $this->Field["idContenido"] = $this->scapingData($IdContenido);
         $this->listModifiedField["idContenido"] = true;
       }

       public function setIdPagina($IdPagina)
       {
         $this->Field["idPagina"] = $this->scapingData($IdPagina);
         $this->listModifiedField["idPagina"] = true;
       }

       public function setIdModulo($IdModulo)
       {
         $this->Field["idModulo"] = $this->scapingData($IdModulo);
         $this->listModifiedField["idModulo"] = true;
       }

       public function setTextContenido($TextContenido)
       {
         $this->Field["textContenido"] = $this->scapingData($TextContenido);
         $this->listModifiedField["textContenido"] = true;
       }


       
       /**
       * Este método devuelve el valor del campo especificado en la instrucción SELECT 
       * @fieldName, ejemplo de valores que se pueden admitir: 
       * nombre de campos que no esten previamente definidos, alias u otras utilidades
       */
       function getGenericField($fieldName)
       {
         return $this->Field[$fieldName];
       }
	   
       /**
	*Version abreviada de getGenericField
        */
       public function get($fieldName){return $this->Field[$fieldName];}
	   
       
       function getPkIdContenido()
       {
        return  $this->listPk["idContenido"];
       }

       function getIdPagina()
       {
         return $this->Field["idPagina"];
       }

       function getIdModulo()
       {
         return $this->Field["idModulo"];
       }

       function getTextContenido()
       {
         return $this->Field["textContenido"];
       }


    }
    