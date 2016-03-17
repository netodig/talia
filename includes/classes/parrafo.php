<?php 

class Parrafoc
{	
	function __construct(){}
	
	public static function generaoraciones($texto)
	{
		//separo las oraciones por los puntos
		$patter= "/[^.!?\\s][^.!?]*(?:[.!?:](?!['\"„“]?\\s|$)[^.!?]*)*[.!?:]?['\"„“]?(?=\\s|$)/";
		
		$oracionesDev=array();
		$matches=array();

		preg_match_all($patter,$texto,$matches);
		$i=1;
		
		foreach($matches[0] as $o)
		{
			$existepos=strpos($o,"*@*")===false;
			
			if(!$existepos)
			{
				//la anterior tenia salto
				//echo "----".$o."----";
				if($i-1>=1)
				{
					$oracionesDev[$i-1]["salto"]=1;
				}
				
				$o=str_replace("*@*","",$o);
			}
			
			$oracionesDev[$i]=array("oracion"=>str_replace('\"','"',$o),"salto"=>0);
			$i++;
		}
		
		/*$oracionespuntos=explode(".",$texto);
		
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
		}*/
		
		return $oracionesDev;
		
	}
	
}
?>