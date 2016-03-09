<?php
    
      class EmailsExtend extends Emails
      {
         public function getListadoEmails($limit="")
			{
				
				$query="select e.*, er.titulo, er.texto, er.id as ider from emails_plantilla as e left join emails as er on er.tipo=e.id  $limit";
				
	
				
				return $this->Select($query);
			}
			
			public function getEmail($idtipo)
			{
				
				$query="select e.*, er.titulo, er.texto, er.emailde, er.id as ider from emails_plantilla as e left join emails as er on er.tipo=e.id  where e.id=$idtipo";
				
				return $this->Select($query);
			}
			
			public function getEmailCode($code)
			{
				
				$query="select e.*, er.titulo, er.texto, er.emailde, er.id as ider, trad.traduccion from emails_plantilla as e left join emails as er on er.tipo=e.id left join traduccion as trad on trad.idobject=e.id and trad.tabla='emails_plantilla' and idiomat='".ELIDIOMA."'  where e.code='$code'";
				
				return $this->Select($query);
			}
			
      }
    