<?php
    class Fotos
    {
       var $conn;       
       var $Field;
       var $auxRecords;	   
       var $formatFields;
       var $listPk;
       var $listPkFormat;
       var $listModifiedField;
       var $listField;
 
       public function Fotos()
       {
          $this->conn = JFactory::getDbo();          
          $this->Field = array(); 
          //aqui se van a guardar los formatos de los campos
          $this->formatFields = array('nombrearchivo'=>"`fotos`.`nombrearchivo` = '%s'", 'tipofoto'=>"`fotos`.`tipofoto` = %s", 'idext'=>"`fotos`.`idext` = %s", 'pie'=>"`fotos`.`pie` = '%s'", 'idtext2'=>"`fotos`.`idtext2` = %s", 'orden'=>"`fotos`.`orden` = %s");
          //listado de llaves primarias
          $this->listPk = array();
          //formato de las llaves primarias
          $this->listPkFormat = array("idfoto"=>"`fotos`.`idfoto` = %s");
          //listado de campos que contiene la tabla Fotos
          $this->listField = array("idfoto"=>"idfoto", "nombrearchivo"=>"nombrearchivo", "tipofoto"=>"tipofoto", "idext"=>"idext", "pie"=>"pie", "idtext2"=>"idtext2", "orden"=>"orden");
          //listado de campos que se modifican a traves del uso de la clase
          $this->listModifiedField = array();		  
          
          $this->Field["idfoto"] = 0;
          $this->Field["nombrearchivo"] = "";
          $this->Field["tipofoto"] = 0;
          $this->Field["idext"] = 0;
          $this->Field["pie"] = "";
          $this->Field["idtext2"] = 0;
          $this->Field["orden"] = 0;		  
       }
            
       
       public function Save()
       {
          
     	  if($this->listPk["idfoto"])
     	  { 
			$this->conn->voidQuery($this->Update());
     	  }
     	  else
     	  {     	

			$this->conn->voidQuery($this->Insert());
            if($this->conn->getInsertId())
     	    $this->listPk["idfoto"] = $this->conn->getInsertId();     	         	
     	  }
		  return $this->conn->getError() == "";     	  
     	
       }
       
       public function Insert()
       {
          return $query = sprintf("insert into `fotos` (`fotos`.`nombrearchivo`, `fotos`.`tipofoto`, `fotos`.`idext`, `fotos`.`pie`, `fotos`.`idtext2`, `fotos`.`orden`) VALUES('%s', %s, %s, '%s', %s, %s)", $this->Field["nombrearchivo"], $this->Field["tipofoto"], $this->Field["idext"], $this->Field["pie"], $this->Field["idtext2"], $this->Field["orden"]);
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
       	   
       	  return $query = "update `fotos` set ".implode(", ", $intersecUpdateField)." where ".implode(" and ", $intersecPk);
       }
       
       public function Delete()
       {
          $query =sprintf("delete from `fotos` where `fotos`.`idfoto` = %s", $this->Field["idfoto"]);
          return $this->conn->voidQuery($query);
       }
       
       public function Select($query = "")
       {
          if($query == "")          
            $query = "select * from `fotos`";             
          
          return $this->Hydrating($query);          
       }
       
       /**
       * Este metodo devuelve un array con el objeto de tipo Fotos
       * dado un ID determinado
       */
       public function getFotosById($Idfoto)
       {
         return $this->SelectConditional(sprintf("where `fotos`.`idfoto` = %s", $Idfoto));
       }
             
       /**
       * por el parametro $condition se pasan condiciones SQL para hacer un select mas especifico
       * Ejemplo
       * Where usuario = "pepe" and edad = "25"
       */
       public function SelectConditional($condition)
       {
         $query = "select SQL_CALC_FOUND_ROWS `fotos`.`idfoto`, `fotos`.`nombrearchivo`, `fotos`.`tipofoto`, `fotos`.`idext`, `fotos`.`pie`, `fotos`.`idtext2`, `fotos`.`orden` from `fotos` $condition";
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
          $query = "select $fAgregado($elemento) as result from `fotos` $condition";
     	  
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
     	      $object = new  FotosExtend();			  
     	      $object->Field = $row;
     	      //obtiene todas la clave/valores que sean iguales a los campos de la tabla Fotos
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

               if($params["idfoto"]) $cond[] = "`fotos`.`idfoto`=".$params["idfoto"]; 

                if($params["nombrearchivo"]) $cond[] = "`fotos`.`nombrearchivo`like '%".$params["nombrearchivo"]."%'"; 

                if($params["tipofoto"]) $cond[] = "`fotos`.`tipofoto`=".$params["tipofoto"]; 

                if($params["idext"]) $cond[] = "`fotos`.`idext`=".$params["idext"]; 

                if($params["pie"]) $cond[] = "`fotos`.`pie`like '%".$params["pie"]."%'"; 

                if($params["idtext2"]) $cond[] = "`fotos`.`idtext2`=".$params["idtext2"]; 

                if($params["orden"]) $cond[] = "`fotos`.`orden`=".$params["orden"]; 

                $q = $cond[0] ? "where ".implode(" and ", $cond) : "";

               $limit = $maxRows ? "limit $startRows, $maxRows" : "";

    	   return $this->Select("select SQL_CALC_FOUND_ROWS `fotos`.`idfoto`, `fotos`.`nombrearchivo`, `fotos`.`tipofoto`, `fotos`.`idext`, `fotos`.`pie`, `fotos`.`idtext2`, `fotos`.`orden` from `fotos` $q $limit");
    	}
      
      /**      
      * hace un conteo de los resultados totales de la busqueda
      */	
      public function SearchCount($params = array())
    	{
               $cond = array();

               if($params["idfoto"]) $cond[] = "`fotos`.`idfoto`=".$params["idfoto"]; 

                if($params["nombrearchivo"]) $cond[] = "`fotos`.`nombrearchivo`like '%".$params["nombrearchivo"]."%'"; 

                if($params["tipofoto"]) $cond[] = "`fotos`.`tipofoto`=".$params["tipofoto"]; 

                if($params["idext"]) $cond[] = "`fotos`.`idext`=".$params["idext"]; 

                if($params["pie"]) $cond[] = "`fotos`.`pie`like '%".$params["pie"]."%'"; 

                if($params["idtext2"]) $cond[] = "`fotos`.`idtext2`=".$params["idtext2"]; 

                if($params["orden"]) $cond[] = "`fotos`.`orden`=".$params["orden"]; 

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

       
       public function setPkIdfoto($Idfoto)
       {
         $this->listPk["idfoto"] = $this->scapingData($Idfoto);
       }

       public function setIdfoto($Idfoto)
       {
         $this->Field["idfoto"] = $this->scapingData($Idfoto);
         $this->listModifiedField["idfoto"] = true;
       }

       public function setNombrearchivo($Nombrearchivo)
       {
         $this->Field["nombrearchivo"] = $this->scapingData($Nombrearchivo);
         $this->listModifiedField["nombrearchivo"] = true;
       }

       public function setTipofoto($Tipofoto)
       {
         $this->Field["tipofoto"] = $this->scapingData($Tipofoto);
         $this->listModifiedField["tipofoto"] = true;
       }

       public function setIdext($Idext)
       {
         $this->Field["idext"] = $this->scapingData($Idext);
         $this->listModifiedField["idext"] = true;
       }

       public function setPie($Pie)
       {
         $this->Field["pie"] = $this->scapingData($Pie);
         $this->listModifiedField["pie"] = true;
       }

       public function setIdtext2($Idtext2)
       {
         $this->Field["idtext2"] = $this->scapingData($Idtext2);
         $this->listModifiedField["idtext2"] = true;
       }

       public function setOrden($Orden)
       {
         $this->Field["orden"] = $this->scapingData($Orden);
         $this->listModifiedField["orden"] = true;
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
	   
       
       function getPkIdfoto()
       {
        return  $this->listPk["idfoto"];
       }

       function getNombrearchivo()
       {
         return $this->Field["nombrearchivo"];
       }

       function getTipofoto()
       {
         return $this->Field["tipofoto"];
       }

       function getIdext()
       {
         return $this->Field["idext"];
       }

       function getPie()
       {
         return $this->Field["pie"];
       }

       function getIdtext2()
       {
         return $this->Field["idtext2"];
       }

       function getOrden()
       {
         return $this->Field["orden"];
       }


    }
    