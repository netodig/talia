<?php
    class Userinter
    {
       var $conn;       
       var $Field;
       var $auxRecords;	   
       var $formatFields;
       var $listPk;
       var $listPkFormat;
       var $listModifiedField;
       var $listField;
 
       public function Userinter()
       {
          $this->conn = JFactory::getDbo();          
          $this->Field = array(); 
          //aqui se van a guardar los formatos de los campos
          $this->formatFields = array('name'=>"`userinter`.`name` = '%s'", 'clave'=>"`userinter`.`clave` = '%s'", 'tipo'=>"`userinter`.`tipo` = %s", 'email'=>"`userinter`.`email` = '%s'", 'nombre'=>"`userinter`.`nombre` = '%s'", 'apellidos'=>"`userinter`.`apellidos` = '%s'", 'dni'=>"`userinter`.`dni` = '%s'");
          //listado de llaves primarias
          $this->listPk = array();
          //formato de las llaves primarias
          $this->listPkFormat = array("id"=>"`userinter`.`id` = %s");
          //listado de campos que contiene la tabla Userinter
          $this->listField = array("id"=>"id", "name"=>"name", "clave"=>"clave", "tipo"=>"tipo", "email"=>"email", "nombre"=>"nombre", "apellidos"=>"apellidos", "dni"=>"dni");
          //listado de campos que se modifican a traves del uso de la clase
          $this->listModifiedField = array();		  
          
          $this->Field["id"] = 0;
          $this->Field["name"] = "";
          $this->Field["clave"] = "";
          $this->Field["tipo"] = 0;
          $this->Field["email"] = "";
          $this->Field["nombre"] = "";
          $this->Field["apellidos"] = "";
          $this->Field["dni"] = "";		  
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
          return $query = sprintf("insert into `userinter` (`userinter`.`name`, `userinter`.`clave`, `userinter`.`tipo`, `userinter`.`email`, `userinter`.`nombre`, `userinter`.`apellidos`, `userinter`.`dni`) VALUES('%s', '%s', %s, '%s', '%s', '%s', '%s')", $this->Field["name"], $this->Field["clave"], $this->Field["tipo"], $this->Field["email"], $this->Field["nombre"], $this->Field["apellidos"], $this->Field["dni"]);
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
       	   
       	  return $query = "update `userinter` set ".implode(", ", $intersecUpdateField)." where ".implode(" and ", $intersecPk);
       }
       
       public function Delete()
       {
          $query =sprintf("delete from `userinter` where `userinter`.`id` = %s", $this->Field["id"]);
          return $this->conn->voidQuery($query);
       }
       
       public function Select($query = "")
       {
          if($query == "")          
            $query = "select * from `userinter`";             
          
          return $this->Hydrating($query);          
       }
       
       /**
       * Este metodo devuelve un array con el objeto de tipo Userinter
       * dado un ID determinado
       */
       public function getUserinterById($Id)
       {
         return $this->SelectConditional(sprintf("where `userinter`.`id` = %s", $Id));
       }
	   
	   /**
       * Este metodo devuelve un array con el objeto de tipo Userinter
       * dado un ID determinado
       */
       public function getByIdInter($Id)
       {
         return $this->SelectConditional(sprintf("where `userinter`.`id` = %s", $Id));
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
         $query = "select SQL_CALC_FOUND_ROWS `userinter`.`id`, `userinter`.`name`, `userinter`.`clave`, `userinter`.`tipo`, `userinter`.`email`, `userinter`.`nombre`, `userinter`.`apellidos`, `userinter`.`dni` from `userinter` $condition";
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
          $query = "select $fAgregado($elemento) as result from `userinter` $condition";
     	  
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
     	      $object = new  UserinterExtend();			  
     	      $object->Field = $row;
     	      //obtiene todas la clave/valores que sean iguales a los campos de la tabla Userinter
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

               if($params["id"]) $cond[] = "`userinter`.`id`=".$params["id"]; 

                if($params["name"]) $cond[] = "`userinter`.`name`like '%".$params["name"]."%'"; 

                if($params["clave"]) $cond[] = "`userinter`.`clave`like '%".$params["clave"]."%'"; 

                if($params["tipo"]) $cond[] = "`userinter`.`tipo`=".$params["tipo"]; 

                if($params["email"]) $cond[] = "`userinter`.`email`like '%".$params["email"]."%'"; 

                if($params["nombre"]) $cond[] = "`userinter`.`nombre`like '%".$params["nombre"]."%'"; 

                if($params["apellidos"]) $cond[] = "`userinter`.`apellidos`like '%".$params["apellidos"]."%'"; 

                if($params["dni"]) $cond[] = "`userinter`.`dni`like '%".$params["dni"]."%'"; 

                $q = $cond[0] ? "where ".implode(" and ", $cond) : "";

               $limit = $maxRows ? "limit $startRows, $maxRows" : "";

    	   return $this->Select("select SQL_CALC_FOUND_ROWS `userinter`.`id`, `userinter`.`name`, `userinter`.`clave`, `userinter`.`tipo`, `userinter`.`email`, `userinter`.`nombre`, `userinter`.`apellidos`, `userinter`.`dni` from `userinter` $q $limit");
    	}
      
      /**      
      * hace un conteo de los resultados totales de la busqueda
      */	
      public function SearchCount($params = array())
    	{
               $cond = array();

               if($params["id"]) $cond[] = "`userinter`.`id`=".$params["id"]; 

                if($params["name"]) $cond[] = "`userinter`.`name`like '%".$params["name"]."%'"; 

                if($params["clave"]) $cond[] = "`userinter`.`clave`like '%".$params["clave"]."%'"; 

                if($params["tipo"]) $cond[] = "`userinter`.`tipo`=".$params["tipo"]; 

                if($params["email"]) $cond[] = "`userinter`.`email`like '%".$params["email"]."%'"; 

                if($params["nombre"]) $cond[] = "`userinter`.`nombre`like '%".$params["nombre"]."%'"; 

                if($params["apellidos"]) $cond[] = "`userinter`.`apellidos`like '%".$params["apellidos"]."%'"; 

                if($params["dni"]) $cond[] = "`userinter`.`dni`like '%".$params["dni"]."%'"; 

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

       public function setName($Name)
       {
         $this->Field["name"] = $this->scapingData($Name);
         $this->listModifiedField["name"] = true;
       }

       public function setClave($Clave)
       {
         $this->Field["clave"] = $this->scapingData($Clave);
         $this->listModifiedField["clave"] = true;
       }

       public function setTipo($Tipo)
       {
         $this->Field["tipo"] = $this->scapingData($Tipo);
         $this->listModifiedField["tipo"] = true;
       }

       public function setEmail($Email)
       {
         $this->Field["email"] = $this->scapingData($Email);
         $this->listModifiedField["email"] = true;
       }

       public function setNombre($Nombre)
       {
         $this->Field["nombre"] = $this->scapingData($Nombre);
         $this->listModifiedField["nombre"] = true;
       }

       public function setApellidos($Apellidos)
       {
         $this->Field["apellidos"] = $this->scapingData($Apellidos);
         $this->listModifiedField["apellidos"] = true;
       }

       public function setDni($Dni)
       {
         $this->Field["dni"] = $this->scapingData($Dni);
         $this->listModifiedField["dni"] = true;
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

       function getName()
       {
         return $this->Field["name"];
       }

       function getClave()
       {
         return $this->Field["clave"];
       }

       function getTipo()
       {
         return $this->Field["tipo"];
       }

       function getEmail()
       {
         return $this->Field["email"];
       }

       function getNombre()
       {
         return $this->Field["nombre"];
       }

       function getApellidos()
       {
         return $this->Field["apellidos"];
       }

       function getDni()
       {
         return $this->Field["dni"];
       }


    }
    