<?php
	
	function includePubli($pos,$class="publihorizontal",$cant=3,$extracss="")
	{
		$publi= new PublicidadExtend();
		$publi=$publi->getPubliList($pos,"0,$cant");
		if(count($publi))
		{
		?>
		<div class="<?php echo $class ?>">
			<?php foreach($publi as $p)
			{
				?>
        		<div class="publi <?php echo $extracss ?>">
        		<?php echo $p->g('codigo'); ?>
        		</div>
        	<?php
			}?>
		</div>
		<?php 
		}

	}


    function hormiga($idcod,&$camino=array())
    {
        if($idcod)
        {
            $cod = new CodTiposExtend();
            $cod=$cod->getById($idcod);
            $idpadre=$cod->g('idpadre');
            $nomb_cod=$cod->g('nombre');
            $camino[]=$cod;
            hormiga($idpadre,$camino);
        }
        return array_reverse($camino);
    }
    /************************ Perfeccionar  **********************/
    function getNomNivelO($idNivel)
    {
        $result="";
        $niv = new CodNivelExtend();
        $nivs=$niv->getNombreByNivel($idNivel);
        if($nivs)
        {
            $result=$nivs->g('o');
        }
        return $result;
    }
    function getNomNivel($idNivel)
    {
        $result="Hijos";
        $niv = new CodNivelExtend();
        $nivs=$niv->getNombreByNivel($idNivel);
        if($nivs)
        {
            $result=$nivs->g('nombre');
        }
        return $result;
    }
    /***********************************************************/
	
	
	function DeleteFile($fileName)
	{
	   if(file_exists($fileName))
	   {
	    @chmod($fileName, 0777);
	    @unlink($fileName);
	   }
	}

	//formato Y-M-d H:I:s
	function tomktime($fecha)
	{
		$fecha=explode(" ",$fecha);
		$hora=explode(":",$fecha[1]);
		$fecha=explode("-",$fecha[0]);
		
		return mktime(intval($hora[0]),$hora[1],$hora[2],$fecha[1],$fecha[2],$fecha[0]);
	}
	
	function br2nl($data)
	{
		$data=str_replace("<br>",'',$data);
		$data=str_replace("<br/>",'',$data);
		$data=str_replace("<br />",'',$data);
		
		return $data;
	}
	

	function password($password){
	$salt	= md5(mt_rand());
	$encrypt = md5($password.$salt);
	return $encrypt.':'.$salt;
	}
	
	function redondeo05($valor)
	{
		$inttotale= floor($valor);
		$resto=$valor-$inttotale;
		if($resto>0)
		if($resto<=0.5)
		$inttotale+=0.5;
		else
		$inttotale+=1;
		
		//veo el %
		$percent=$inttotale*100/5;
		
		$a = array();
		$a["puntuacion"]=$inttotale;
		$a["percent"]=$percent;
		return $a;
	}
	
	function redondeanormal($valor)
	{
		$inttotale= ceil($valor);

		//veo el %
		$percent=$inttotale*100/5;
		
		$a = array();
		$a["puntuacion"]=$inttotale;
		$a["percent"]=$percent;
		return $a;
	}
	
	function verificagrupo($grupo)
	{
		$encontrado=false;
		

		if(@count($_SESSION['usertype']))
		foreach($_SESSION['usertype'] as $s)
		{
			if($s==$grupo)
			{
				$encontrado=true;
				break;
			}
		}
		return $encontrado;
	}
	
	function passwordsalt($password,$salt){

	$encrypt = md5($password.$salt);
	return $encrypt.':'.$salt;
	}
	
	function generapass()
	{
		$primera=md5(mt_rand());
		
		
		$segunda=md5(mt_rand());
		$tercera=md5(mt_rand());
		
		$txt=$primera.$segunda.$tercera;
	
		
		$clave =strtoupper(preg_replace("/[aeiou0-9]+/i",'',base64_encode($txt)));
		
		return substr($clave,0,10);
	}
	
	function getUserLanguage() { 
       $idioma =substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,5);
       return $idioma; 
  	} 
	

	function generaQuery($campo, $listIds, $operador = '')
	{	   
	   $count = count($listIds);
	   $i = 1;
	   $result = '';
	   foreach($listIds as $ids)
	   {
	      if($i < $count)
		    $result .= " $campo=$ids and ";
		  else
		    $result .= " $campo=$ids ";
	   }
	   
	   return $result;
	}
	
	
	function generaParametrosBusqueda($listparams = array(), $excluir = array())
	{
	   $hidden = '';
	   foreach($listparams as $key=>$value)
	   {
	     if(!in_array($key, $excluir))
		 {
	       if(is_array($value))
		   {
		      foreach($value as $valor)
			   $hidden .= ' <input name="'.$key.'[]" id="'.$key.'" type="hidden" value="'.$valor.'" /> ';
		   }
		   else
		     $hidden .= " <input name=\"$key\" id=\"$key\" type=\"hidden\" value=\"$value\" /> ";
		  }
	   }
	   
	   return $hidden;
	}


	
	function fechaentre($fecha,$entre1,$entre2)
	{
		 $fecha= explode("-",$fecha);
		 $fecha=mktime(0,0,0, $fecha[1],$fecha[2],$fecha[0]);
		 
		 $entre1=explode(" ",$entre1);
		 $entre1=explode("-",$entre1[0]);
		 
		 $entre1=mktime(0,0,0, $entre1[1],$entre1[2],$entre1[0]);
		 
		 $entre2=explode(" ",$entre2);
		 $entre2=explode("-",$entre2[0]);
		 
		 $entre2=mktime(23,59,59, $entre2[1],$entre2[2],$entre2[0]);
		 
		 return $fecha>=$entre1 && $fecha<=$entre2;
	}
	
	function paginacionPostBackOfertas($url, $totalRegistros, $current_page, $regitrosPorPaginas = 1, $fordata = '', $idDivUpdate = '', $maxLink = 10)
	{
		$otherPage = $numeroPagina = $_REQUEST['ajaxpage'] != '' ? $_REQUEST['ajaxpage'] : 0;
		$current_page = $current_page != '' ? $current_page * $regitrosPorPaginas : 0;
		$pages_count = (int) ceil($totalRegistros / $regitrosPorPaginas);
				
		$lineLink = '';
		
		 ?>
        
         <?
		 
		 //$i = $numeroPagina;
		 $i = 0;
		 
		 
		 //while($numeroPagina < $pages_count and $i < $maxLink)
		 while($i < $maxLink && $i<$pages_count)
		{
		  if ($numeroPagina != $i)
			   $lineLink .= '
			    <form method="post"  action="'.$url.'">
         <input type="hidden" id="idpelu" name="idpelu" value="<?php echo $id ?>">
         <input type="hidden" id="page" name="page" value="<?php echo $id ?>">
         </form>
			   <a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'&ajaxpage='.($i).'\', \''.$idDivUpdate.'\')">'.($i+1).'</a>';
		  else
			   $lineLink .= '<a class="active" href="javascript:void(0)">'.($i+1).'</a>';				
		  //$numeroPagina++;
		  $i++;
		}
		$lineLink .= '</div>';
        //$lineLink .= '<span class="sig">(anterior)</span> <span class="local">P&aacute;gina '.($numeroPagina+1).' de ('.$pages_count.')</span> <span class="sig">(siguiente)</span>';
        
       
        return $lineLink;
	}
	
	function paginacionEspAjax($url, $totalRegistros, $current_page, $regitrosPorPaginas = 1, $fordata = '', $idDivUpdate = '', $maxLink = 10)
	{
		$otherPage = $numeroPagina = $_REQUEST['ajaxpage'] != '' ? $_REQUEST['ajaxpage'] : 0;
		$current_page = $current_page != '' ? $current_page * $regitrosPorPaginas : 0;
		$pages_count = (int) ceil($totalRegistros / $regitrosPorPaginas);
				
		$lineLink = '<a href="'.$url.'-0.html" class="primero"></a>';
		
		$lineLink = '<div class="flechas">';
		
		if($numeroPagina > 0)//para ir al inicio
		 $lineLink .= '<a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'ajaxpage=0\', \''.$idDivUpdate.'\')" class="prim"></a>';
		else 
		 $lineLink .= '<a href="javascript:void(0)" class="prim"></a>';
		 
		if($numeroPagina > 0)
		 $lineLink .= '<a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'&ajaxpage='.($numeroPagina-1).'\', \''.$idDivUpdate.'\')" class="atras"></a></div>';
		else
		 $lineLink .= '<a href="javascript:void(0)" class="atras"></a></div>'; 
		
		$lineLink .= '<div class="tpiegrid">';
		 
		 //$i = $numeroPagina;
		 $i = 0;
		 
		 
		 //while($numeroPagina < $pages_count and $i < $maxLink)
		 while($i < $maxLink && $i<$pages_count)
		{
		  if ($numeroPagina != $i)
			   $lineLink .= '<a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'&ajaxpage='.($i).'\', \''.$idDivUpdate.'\')">'.($i+1).'</a>';
		  else
			   $lineLink .= '<a class="active" href="javascript:void(0)">'.($i+1).'</a>';				
		  //$numeroPagina++;
		  $i++;
		}
		$lineLink .= '</div>';
        //$lineLink .= '<span class="sig">(anterior)</span> <span class="local">P&aacute;gina '.($numeroPagina+1).' de ('.$pages_count.')</span> <span class="sig">(siguiente)</span>';
        
        $lineLink .= '<div class="flechas">'; 
        
        if(($otherPage < $pages_count-1))
         $lineLink .= '<a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'&ajaxpage='.($otherPage+1).'\', \''.$idDivUpdate.'\')" class="sigatras">';
        else
         $lineLink .= '<a href="javascript:void(0)" class="sigatras"></a>'; 
        
        if($otherPage < $numeroPagina)
          $lineLink .= '<a href="javascript:void(0)" onclick="cargaAfuera(\''.$url.'\', \''.$fordata.'&ajaxpage='.($pages_count-1).'\', \''.$idDivUpdate.'\')" class="sigprim"></a></div>';
        else  
          $lineLink .= '<a href="javascript:void(0)" class="sigprim"></a></div>';
        return $lineLink;
	}
	
	function calculaSemanaEmbarazo($fecha, $fechafur)
	{
		$fecha=explode("-",$fecha);
		$fechafur=explode("-",$fechafur);
		
		$fecha=mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]);
		
		$fechafur=mktime(0,0,0,$fechafur[1],$fechafur[2],$fechafur[0]);
		
		$segundos_diferencia = $fecha - $fechafur;
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
		$dias_diferencia = abs($dias_diferencia);
		$dias_diferencia = floor($dias_diferencia);

		return ceil($dias_diferencia/7);

	}
	

	
	function NombreFileRandom($NombreFichero, $direccionFichero, &$prefijo)
{
	$prefijo = substr(md5(rand(1, 999999999999999999999)*microtime()), 0, 6);
	$fullFilePath = $direccionFichero.$prefijo.$NombreFichero;
	if(file_exists($fullFilePath))	
	  NombreFileRandom($NombreFichero, $direccionFichero,$prefijo);	
}
?>