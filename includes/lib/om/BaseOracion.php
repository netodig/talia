<?php
    class Oracion
    {
       var $conn;       
       var $Field;
       var $auxRecords;	   
       var $formatFields;
       var $listPk;
       var $listPkFormat;
       var $listModifiedField;
       var $listField;
 
       public function Oracion()
       {
          $this->conn = JFactory::getDbo();          
          $this->Field = array(); 
          //aqui se van a guardar los formatos de los campos
          $this->formatFields = array('idparrafo'=>"`oracion`.`idparrafo` = %s", 'lang'=>"`oracion`.`lang` = '%s'", 'texto'=>"`oracion`.`texto` = '%s'", 'salto'=>"`oracion`.`salto` = %s", 'numero'=>"`oracion`.`numero` = %s");
          //listado de llaves primarias
          $this->listPk = array();
          //formato de las llaves primarias
          $this->listPkFormat = array("id"=>"`oracion`.`id` = %s");
          //listado de campos que contiene la tabla Oracion
          $this->listField = array("id"=>"id", "idparrafo"=>"idparrafo", "lang"=>"lang", "texto"=>"texto", "salto"=>"salto", "numero"=>"numero");
          //listado de campos que se modifican a traves del uso de la clase
          $this->listModifiedField = array();		  
          
          $this->Field["id"] = 0;
          $this->Field["idparrafo"] = 0;
          $this->Field["lang"] = "";
          $this->Field["texto"] = "";
          $this->Field["salto"] = 0;
          $this->Field["numero"] = 0;		  
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
          return $query = sprintf("insert into `oracion` (`oracion`.`idparrafo`, `oracion`.`lang`, `oracion`.`texto`, `oracion`.`salto`, `oracion`.`numero`) VALUES(%s, '%s', '%s', %s, %s)", $this->Field["idparrafo"], $this->Field["lang"], $this->Field["texto"], $this->Field["salto"], $this->Field["numero"]);
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
       	   
       	  return $query = "update `oracion` set ".implode(", ", $intersecUpdateField)." where ".implode(" and ", $intersecPk);
       }
       
       public function Delete()
       {
          $query =sprintf("delete from `oracion` where `oracion`.`id` = %s", $this->Field["id"]);
          return $this->conn->voidQuery($query);
       }
       
       public function Select($query = "")
       {
          if($query == "")          
            $query = "select * from `oracion`";             
          
          return $this->Hydrating($query);          
       }
       
       /**
       * Este metodo devuelve un array con el objeto de tipo Oracion
       * dado un ID determinado
       */
       public function getOracionById($Id)
       {
         return $this->SelectConditional(sprintf("where `oracion`.`id` = %s", $Id));
       }
	   
	   /**
       * Este metodo devuelve un array con el objeto de tipo Oracion
       * dado un ID determinado
       */
       public function getByIdInter($Id)
       {
         return $this->SelectConditional(sprintf("where `oracion`.`id` = %s", $Id));
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
         $query = "select SQL_CALC_FOUND_ROWS `oracion`.`id`, `oracion`.`idparrafo`, `oracion`.`lang`, `oracion`.`texto`, `oracion`.`salto`, `oracion`.`numero` from `oracion` $condition";
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
          $query = "select $fAgregado($elemento) as result from `oracion` $condition";
     	  
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
     	      $object = new  OracionExtend();			  
     	      $object->Field = $row;
     	      //obtiene todas la clave/valores que sean iguales a los campos de la tabla Oracion
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

               if($params["id"]) $cond[] = "`oracion`.`id`=".$params["id"]; 

                if($params["idparrafo"]) $cond[] = "`oracion`.`idparrafo`=".$params["idparrafo"]; 

                if($params["lang"]) $cond[] = "`oracion`.`lang`like '%".$params["lang"]."%'"; 

                if($params["texto"]) $cond[] = "`oracion`.`texto`like '%".$params["texto"]."%'"; 

                if($params["salto"]) $cond[] = "`oracion`.`salto`=".$params["salto"]; 

                if($params["numero"]) $cond[] = "`oracion`.`numero`=".$params["numero"]; 

                $q = $cond[0] ? "where ".implode(" and ", $cond) : "";

               $limit = $maxRows ? "limit $startRows, $maxRows" : "";

    	   return $this->Select("select SQL_CALC_FOUND_ROWS `oracion`.`id`, `oracion`.`idparrafo`, `oracion`.`lang`, `oracion`.`texto`, `oracion`.`salto`, `oracion`.`numero` from `oracion` $q $limit");
    	}
      
      /**      
      * hace un conteo de los resultados totales de la busqueda
      */	
      public function SearchCount($params = array())
    	{
               $cond = array();

               if($params["id"]) $cond[] = "`oracion`.`id`=".$params["id"]; 

                if($params["idparrafo"]) $cond[] = "`oracion`.`idparrafo`=".$params["idparrafo"]; 

                if($params["lang"]) $cond[] = "`oracion`.`lang`like '%".$params["lang"]."%'"; 

                if($params["texto"]) $cond[] = "`oracion`.`texto`like '%".$params["texto"]."%'"; 

                if($params["salto"]) $cond[] = "`oracion`.`salto`=".$params["salto"]; 

                if($params["numero"]) $cond[] = "`oracion`.`numero`=".$params["numero"]; 

                $q = $this->parseParams($cond);


    	   return $this->functionsAgregate("*", "count", $q);
    	}
       
      //addRelation
	  
	  //get de aristides
	   public function g($id,$num="",$post="")
		 {
			 $data=$this->get($id.$post);
			 
			  if(function_exists("checkDecode") && function_exists("decode") && defined("ENCODESEED"))
			 {
				 
			 if(checkDecode($data))
			 $data=decode($data, ENCODESEED);
			 }
			 
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

       public function setIdparrafo($Idparrafo)
       {
         $this->Field["idparrafo"] = $this->scapingData($Idparrafo);
         $this->listModifiedField["idparrafo"] = true;
       }

       public function setLang($Lang)
       {
         $this->Field["lang"] = $this->scapingData($Lang);
         $this->listModifiedField["lang"] = true;
       }

       public function setTexto($Texto)
       {
         $this->Field["texto"] = $this->scapingData($Texto);
         $this->listModifiedField["texto"] = true;
       }

       public function setSalto($Salto)
       {
         $this->Field["salto"] = $this->scapingData($Salto);
         $this->listModifiedField["salto"] = true;
       }

       public function setNumero($Numero)
       {
         $this->Field["numero"] = $this->scapingData($Numero);
         $this->listModifiedField["numero"] = true;
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

       function getIdparrafo()
       {
         return $this->Field["idparrafo"];
       }

       function getLang()
       {
         return $this->Field["lang"];
       }

       function getTexto()
       {
         return $this->Field["texto"];
       }

       function getSalto()
       {
         return $this->Field["salto"];
       }

       function getNumero()
       {
         return $this->Field["numero"];
       }


    }
    