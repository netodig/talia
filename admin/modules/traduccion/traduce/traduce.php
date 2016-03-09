<?php
import("classes.helper");
import("upload");
import('funciones');

$elemento=$_REQUEST['elemento'];
$idiomaa=$_REQUEST['idiomas'];

//busco los elementos
  $elementos=new TraduccionTablasExtend();
  $elementos=$elementos->getElementos();
  
  $elems= array();
  $elems[""]="Seleccionar";
  
  $idelems= array();
  $idelems[""]="Seleccionar";
  foreach($elementos as $e)
  {
	  $elems[$e->g('nombretabla')]=$e->g('titulotabla');
	  $idelems[$e->g('nombretabla')]=$e->g('campoid');
  }


$elementoT=$elems[$elemento];
if(!$elemento)
$elementoT="elementos";

global $com;
$titulo="Listado de $elementoT";

?>

<form action="" method="post" id="formespes" enctype="multipart/form-data" name="formespes">
  <h1><?php echo $titulo ?></h1>
  <?
	  if($com["message"])
	  {
    ?>
  <h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
  <?
	 }
	 ?>
  <div class="tablediv">
    <fieldset >
    	 <label class="fr" style="margin-left:10px;" >
         <input  style="margin-top:14px;"class="cb" type="Submit" name="Submit" value="Buscar" />
         </label>
      <label class="fr"> Elemento :<br />
        <?php echo THelper::select('elemento', $elems, $elemento,false); ?> </label>
        <label class="w13p fr"> Idioma :<br />
            
        <?php 
        $p = array();
        $p[] = 'class="w180px"';
        $idioma = new IdiomasTExtend();
        $idiomas = $idioma->getListIdiomas("Elige idioma...");
        echo THelper::select('idiomas', $idiomas, $idiomaa, false, $p);
        //echo THelper::select('idiomas', $idiomasa, $idiomaa,false); 
        ?> </label>
       
    </fieldset>
    
	<?php 
	if($elemento && $idiomaa)
	{
		
		$extratabla= new TraduccionTablasExtend();
		$extratabla=$extratabla->getDataTable($elemento);
		$extratabla=$extratabla[0];
		
		//busco los campos de esa tabla que se traducen
		$camposTabla= new TraduccionExtend();
		$camposTabla=$camposTabla->getCamposTabla($elemento);
		
		$data= new TraduccionTablasExtend();
		$data=$data->getDatosTabla($elemento,$idiomaa,$idelems[$elemento],$extratabla->g('orderby'),$extratabla->g('consulta'));
	
	?>
    <div class="tablediv">
      <table width="100%" border="0" cellspacing="0">
        <tr>
        <?php 
		foreach($camposTabla as $t)
		{

			if($t->g('muestraentitulo'))
			{
		?>
          <th width="20%"><?php echo $t->g('tituloc') ?></th>
          <?php 
			}
		}?>
          <th width="10%">Estado</th>
          <th width="10%" colspan="2">Opciones</th>
        </tr>
        <?php 
		$par="";
		$i=0;
		foreach($data as $d)
		{
			$i++
		?>
        <tr class="<?php echo $par ?>" id="row<?php echo $d->g('id') ?>">
        <?php 
		foreach($camposTabla as $t)
		{
			if($t->g('muestraentitulo'))
			{
		?>
          <td><?php echo $d->get($t->g('campo')) ?></td>
           <?php 
			}
		}?>
          <td><?php 
		  	$estado="status_r.png";
			if($d->g('traduccion'))
			{
				$estado="status_y.png";
				$encontrado=false;
				
				$campotraducido=json_decode($d->g('traduccion'));
				foreach($camposTabla as $cam)
				{
					$cap=$cam->g('campo');
					if($campotraducido->$cap=="")
					{
						$encontrado=true;
						break;
					}
				}
				
				if(!$encontrado)
				$estado="status_g.png";
			}
		  ?>
          	<img src="<?php echo Url::adminimg()?>/traducir/<?php echo $estado ?>" />
          </td>
          <td><a href="<?php echo Url::adminlink("traduccion/traduce/traducir","cid=".$d->g('idtrad')."&tabla=$elemento&idi=$idiomaa&idorigi=".$d->g($idelems[$elemento])) ?>" class="mod"></a></td>
        </tr>
        <?php
		if(!$par)
		$par="par";
		else
		$par=""; 
		}
		?>
      </table>
    </div>
    <?php 
	}
	?>
  </div>
</form>
