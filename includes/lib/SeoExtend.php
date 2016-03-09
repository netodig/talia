<?php
    
      class SeoExtend extends Seo
      {
         public function getSeoPagina($module)
		 {
			 $idi= $_SESSION['idioma'];
			 
			 $query="select ss.* ,s.funcion, trad.traduccion from seo_config as s inner join seo as ss on ss.tipo=s.id and s.module='$module' left join traduccion as trad on trad.idobject=ss.id and trad.tabla='seo' and idiomat='".ELIDIOMA."'";
			 

			 return $this->Select($query);
		 }
      }
    