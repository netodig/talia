<?php
    class CodTipos
    {
       var $conn;       
       var $Field;
       var $auxRecords;	   
       var $formatFields;
       var $listPk;
       var $listPkFormat;
       var $listModifiedField;
       var $listField;
 
       public function CodTipos()
       {
          $this->conn = JFactory::getDbo();          
          $this->Field = array(); 
          //aqui se van a guardar los formatos de los campos
          $this->formatFields = array('nombre'=>"`cod_tipos`.`nombre` = '%s'", 'tipocod'=>"`cod_tipos`.`tipocod` = %s", 'orden'=>"`cod_tipos`.`orden` = %s", 'alias'=>"`cod_tipos`.`alias` = '%s'", 'nivel'=>"`cod_tipos`.`nivel` = %s", 'idpadre'=>"`cod_tipos`.`idpadre` = %s");
          //listado de llaves primarias
          $this->listPk = array();
          //formato de las llaves primarias
          $this->listPkFormat = array("id"=>"`cod_tipos`.`id` = %s");
          //listado de campos que contiene la tabla CodTipos
          $this->listField = array("id"=>"id", "nombre"=>"nombre", "tipocod"=>"tipocod", "orden"=>"orden", "alias"=>"alias", "nivel"=>"nivel", "idpadre"=>"idpadre");
          //listado de campos que se modifican a traves del uso de la clase
          $this->listModifiedField = array();		  
          
          $this->Field["id"] = 0;
          $this->Field["nombre"] = "";
          $this->Field["tipocod"] = 0;
          $this->Field["orden"] = 0;
          $this->Field["alias"] = "";
          $this->Field["nivel"] = 0;
          $this->Field["idpadre"] = 0;		  
       }
            
       
       public function Save()
       {
          
     	  if($this->listPk["id"])
     	  { 
			$this->conn->voidQuery($this->Update());
     	  }
     	  else
     	  {     	    
			$this->conn->voidQuery($this->Insert());
            if($this->conn->getInsertId())
     	    $this->listPk["id"] = $this->conn->getInsertId();     	         	
     	  }
		  return $this->conn->getError() == "";     	  
     	
       }
       
       public function Insert()
       {
          return $query = sprintf("insert into `cod_tipos` (`cod_tipos`.`nombre`, `cod_tipos`.`tipocod`, `cod_tipos`.`orden`, `cod_tipos`.`alias`, `cod_tipos`.`nivel`, `cod_tipos`.`idpadre`) VALUES('%s', %s, %s, '%s', %s, %s)", $this->Field["nombre"], $this->Field["tipocod"], $this->Field["orden"], $this->Field["alias"], $this->Field["nivel"], $this->Field["idpadre"]);
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
       	   
       	  return $query = "update `cod_tipos` set ".implode(", ", $intersecUpdateField)." where ".implode(" and ", $intersecPk);
       }
       
       public function Delete()
       {
          $query =sprintf("delete from `cod_tipos` where `cod_tipos`.`id` = %s", $this->Field["id"]);
          return $this->conn->voidQuery($query);
       }
       
       public function Select($query = "")
       {
          if($query == "")          
            $query = "select * from `cod_tipos`";             
          
          return $this->Hydrating($query);          
       }
       
       /**
       * Este metodo devuelve un array con el objeto de tipo CodTipos
       * dado un ID determinado
       */
       public function getCodTiposById($Id)
       {
         return $this->SelectConditional(sprintf("where `cod_tipos`.`id` = %s", $Id));
       }
	   
	   /**
       * Este metodo devuelve un array con el objeto de tipo CodTipos
       * dado un ID determinado
       */
       public function getByIdInter($Id)
       {
         return $this->SelectConditional(sprintf("where `cod_tipos`.`id` = %s", $Id));
       }
	   
	    public function getById($Id)
       {
         $obj=$this->getByIdInter($Id);
		 
		 return $obj[0];
       }
          
	   	
	     
		     
       /**
       * por el parametro $condition se pasan condiciones SQL para hacer un select mas especifico
       * Ejemplo
       * Where usuario = "pepe" and edad = "25"
       */
       public function SelectConditional($condition)
       {
         $query = "select SQL_CALC_FOUND_ROWS `cod_tipos`.`id`, `cod_tipos`.`nombre`, `cod_tipos`.`tipocod`, `cod_tipos`.`orden`, `cod_tipos`.`alias`, `cod_tipos`.`nivel`, `cod_tipos`.`idpadre` from `cod_tipos` $condition";
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
          $query = "select $fAgregado($elemento) as result from `cod_tipos` $condition";
     	  
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
     	      $object = new  CodTiposExtend();			  
     	      $object->Field = $row;
     	      //obtiene todas la clave/valores que sean iguales a los campos de la tabla CodTipos
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

               if($params["id"]) $cond[] = "`cod_tipos`.`id`=".$params["id"]; 

                if($params["nombre"]) $cond[] = "`cod_tipos`.`nombre`like '%".$params["nombre"]."%'"; 

                if($params["tipocod"]) $cond[] = "`cod_tipos`.`tipocod`=".$params["tipocod"]; 

                if($params["orden"]) $cond[] = "`cod_tipos`.`orden`=".$params["orden"]; 

                if($params["alias"]) $cond[] = "`cod_tipos`.`alias`like '%".$params["alias"]."%'"; 

                if($params["nivel"]) $cond[] = "`cod_tipos`.`nivel`=".$params["nivel"]; 

                if($params["idpadre"]) $cond[] = "`cod_tipos`.`idpadre`=".$params["idpadre"]; 

                $q = $cond[0] ? "where ".implode(" and ", $cond) : "";

               $limit = $maxRows ? "limit $startRows, $maxRows" : "";

    	   return $this->Select("select SQL_CALC_FOUND_ROWS `cod_tipos`.`id`, `cod_tipos`.`nombre`, `cod_tipos`.`tipocod`, `cod_tipos`.`orden`, `cod_tipos`.`alias`, `cod_tipos`.`nivel`, `cod_tipos`.`idpadre` from `cod_tipos` $q $limit");
    	}
      
      /**      
      * hace un conteo de los resultados totales de la busqueda
      */	
      public function SearchCount($params = array())
    	{
               $cond = array();

               if($params["id"]) $cond[] = "`cod_tipos`.`id`=".$params["id"]; 

                if($params["nombre"]) $cond[] = "`cod_tipos`.`nombre`like '%".$params["nombre"]."%'"; 

                if($params["tipocod"]) $cond[] = "`cod_tipos`.`tipocod`=".$params["tipocod"]; 

                if($params["orden"]) $cond[] = "`cod_tipos`.`orden`=".$params["orden"]; 

                if($params["alias"]) $cond[] = "`cod_tipos`.`alias`like '%".$params["alias"]."%'"; 

                if($params["nivel"]) $cond[] = "`cod_tipos`.`nivel`=".$params["nivel"]; 

                if($params["idpadre"]) $cond[] = "`cod_tipos`.`idpadre`=".$params["idpadre"]; 

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

       
       public function setPkId($Id)
       {
         $this->listPk["id"] = $this->scapingData($Id);
       }

       public function setId($Id)
       {
         $this->Field["id"] = $this->scapingData($Id);
         $this->listModifiedField["id"] = true;
       }

       public function setNombre($Nombre)
       {
         $this->Field["nombre"] = $this->scapingData($Nombre);
         $this->listModifiedField["nombre"] = true;
       }

       public function setTipocod($Tipocod)
       {
         $this->Field["tipocod"] = $this->scapingData($Tipocod);
         $this->listModifiedField["tipocod"] = true;
       }

       public function setOrden($Orden)
       {
         $this->Field["orden"] = $this->scapingData($Orden);
         $this->listModifiedField["orden"] = true;
       }

       public function setAlias($Alias)
       {
         $this->Field["alias"] = $this->scapingData($Alias);
         $this->listModifiedField["alias"] = true;
       }

       public function setNivel($Nivel)
       {
         $this->Field["nivel"] = $this->scapingData($Nivel);
         $this->listModifiedField["nivel"] = true;
       }

       public function setIdpadre($Idpadre)
       {
         $this->Field["idpadre"] = $this->scapingData($Idpadre);
         $this->listModifiedField["idpadre"] = true;
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
	   
       
       function getPkId()
       {
        return  $this->listPk["id"];
       }

       function getNombre()
       {
         return $this->Field["nombre"];
       }

       function getTipocod()
       {
         return $this->Field["tipocod"];
       }

       function getOrden()
       {
         return $this->Field["orden"];
       }

       function getAlias()
       {
         return $this->Field["alias"];
       }

       function getNivel()
       {
         return $this->Field["nivel"];
       }

       function getIdpadre()
       {
         return $this->Field["idpadre"];
       }


    }
    