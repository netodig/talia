<?php 

class Parrafoc
{	
	function __construct(){}
	
	public static function generaoraciones($texto)
	{
		//separo las oraciones por los puntos
		$oracionespuntos=explode(".",$texto);
		
		$oracionesDev=array();
		$i=1;
		foreach($oracionespuntos as $o)
		{
			$o=nl2br($o);
			
			$existepos=strpos($o,"<br />")===false;
			
			if(!$existepos)
			{
				//la anterior tenia salto
				if($i-1>=1)
				{
					$oracionesDev[$i-1]["salto"]=1;
				}
				
				$o=str_replace("<br />","",$o);
			}
			
			$oracionesDev[$i]=array("oracion"=>$o,"salto"=>0);
			
			$i++;
		}
		
		return $oracionesDev;
		
	}
	
}
?>