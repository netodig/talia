<?php
    
      class UserinterExtend extends Userinter
      {
        public function getLogin($name, $clave)
		 {
			 $query="select * from userinter where (name='$name' or email='$name') && clave='$clave'";
			 
			 return $this->Select($query);
			 
		 }
		 
		  public function getLoginTipo($name, $clave,$tipo)
		 {
			 $query="select * from userinter where (name='$name' or email='$name') && clave='$clave' and tipo in ($tipo)";
			 
			 return $this->Select($query);
			 
		 }
		 
		  public function getLoginMovil($code)
		 {
			 $query="select * from userinter where (concat(name,clave))='$code' or (concat(email,clave))='$code'";
			 

			 return $this->Select($query);
		 }
		 
		 public function getLoginName($name,$id="")
		 {
			 
			 $query="select * from userinter where name='$name' and id<>'$id' ";
			 
			 return $this->Select($query);
			 
		 }
		  public function getEmailUser($email,$id="")
		 {
			 $query="select * from userinter where email='$email' and id<>'$id' ";
			 
			 return $this->Select($query);
			 
		 }
		 
		 public function getUsuarios($nombre,$tipo,$orden,$campo,$limit="")
		 {
			  $and=array();
			 if($nombre)
			 $and[]="concat(u.nombre,' ',apellidos) like '%$nombre%'";
			 
			 if($tipo)
			  $and[]="tipo=$tipo";
			
			 if($and[0])
			 {
				 $and=implode(" and ",$and);
				 $and=" where ".$and;
			 }
			 else
			 $and="";
			 
			 $elorden="";
			 if($campo)
			 { 
			 $elorden="order by $campo $orden";
			 }
			 
			 $query="select SQL_CALC_FOUND_ROWS  u.*,p.nombre as perfil from userinter as u left join perfiles as p on p.id=u.tipo $and $elorden $limit";
			 
			 
			 return $this->Select($query);
		 }
		 
		 public function getEmbarazadas($nombre,$tipo,$orden,$campo,$limit="")
		 {
			  $and=array();
			 if($nombre)
			 $and[]="concat(u.nombre,' ',apellidos) like '%$nombre%'";
			 
			 if($tipo)
			  $and[]="tipo=$tipo";
			
			 if($and[0])
			 {
				 $and=implode(" and ",$and);
				 $and=" where ".$and;
			 }
			 else
			 $and="";
			 
			 $elorden="";
			 if($campo)
			 { 
			 $elorden="order by $campo $orden";
			 }
			 
			 $query="select SQL_CALC_FOUND_ROWS  u.*,p.nombre as perfil, count(d.id) as diarios, count(pd.id) as preguntas from userinter as u left join perfiles as p on p.id=u.tipo left join diario as d on d.iduser=u.id left join preguntasdoc as pd on pd.iduser=u.id $and group by u.id $elorden $limit";
			 
			 
			 return $this->Select($query);
		 }
		 
		 public function getEmbarazada($id)
		 {
			 $query="select SQL_CALC_FOUND_ROWS  u.*,p.nombre as perfil, count(d.id) as diarios, count(pd.id) as preguntas from userinter as u left join perfiles as p on p.id=u.tipo left join diario as d on d.iduser=u.id left join preguntasdoc as pd on pd.iduser=u.id where u.id=$id group by u.id";
			 
			 return $this->Select($query);
		 }
		 
		  public function revisauser($email)
		 {
			 $query="select count(*) as cant from userinter where email='$email'";

			 $q= $this->Select($query);
			 
			 $q=$q[0];
			 return $q->g('cant');
			 
		 }
		  public function getUsuariologin($email)
		 {
			 $query="select * from userinter where email='$email'";
			 return $this->Select($query);
			 
		 }
      }
    