<?
import("classes.helper");
import('funciones');

$tabla=$_REQUEST['tabla'];

$extratabla= new TraduccionTablasExtend();
$extratabla=$extratabla->getDataTable($tabla);
$extratabla=$extratabla[0];

global $com;
$titulo="Campos de la tabla ".$tabla;
?>

<h1><?php echo $titulo ?></h1>
<?
	  if($com["message"])
	  {
   		?>
		<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
        <br>
		<?
	 }
	 ?>
<?php 
  $traducciones= new TraduccionExtend();
  $campostabla=$traducciones->getCamposTabla($tabla);
  $traducciones=$traducciones->getTablaDes($tabla);
  
  $datoscampos=array();
  $datostitles=array();
  $datosmuestra=array();
  
  foreach( $campostabla as $c)
  {
	  $datoscampos[$c->g('campo')]=$c->g('tipotrad');
	  $datostitles[$c->g('campo')]=$c->g('tituloc');
	  $datosmuestra[$c->g('campo')]=$c->g('muestraentitulo');
  }
  
  ?>
    <a class="fr back" href="<?php echo Url::adminlink("traduccion/traduce/tablas") ?>">Volver al listado</a>
  <form action="" method="post" id="formtraduce" enctype="multipart/form-data" name="formtraduce">
<div class="tablediv">
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="40%">Campo</th>
        <th width="20%">Tipo</th>
        <th width="20%">Título</th>
         <th width="20%">Muestra Listado</th>
        <th width="20%">Traducción</th>
      </tr>
      <?php 
		$par="";
		$i=0;
		
		$traduces=array(0=>"No traduce",
		1=>"Texto pequeño",
		4=>"Texto pequeño con contador",
		2=>"Texto grande",
		5=>"Texto grande con contador",
		3=>"Editor",
		6=>"Invisible",
		7=>"Solo info");
		
		foreach($traducciones as $t)
		{
			$i++
		?>
      	<tr class="<?php echo $par ?>" id="row<?php echo $t->g('Field') ?>">
        <td><?php echo $t->g('Field') ?></td>
        <td><?php echo $t->g('Type') ?></td>
        <td>
        <?php 
		$titlea=$datostitles[$t->g('Field')];
		if(!$titlea)
		$titlea=$t->g('Field');
		?>
        <input type="text" name="<?php echo $t->g('Field') ?>titulo" id="<?php echo $t->g('Field') ?>titulo" value="<?php echo $titlea ?>" /></td>
        <td>
        <input type="checkbox" <?php if($datosmuestra[$t->g('Field')]){ ?> checked="checked"<? }?> name="<?php echo $t->g('Field') ?>muestra" id="<?php echo $t->g('Field') ?>muestra" value="1" /></td>
        <td>
        <?php echo THelper::select($t->g('Field')."traduce", $traduces, $datoscampos[$t->g('Field')],false); ?>
        </td>
      </tr>
      <?php
		if(!$par)
		$par="par";
		else
		$par=""; 
		}
		?>
    </table>
    
    <div class="w80p cb">
    <label class="fl">
    Condición:
     <input type="text" size="30" name="condicion" id="condicion" value="<?php echo $extratabla->g('consulta') ?>" />
    </label>
     <label class="fl">
    Orden:
     <input type="text" size="30" name="ordenini" id="ordenini" value="<?php echo $extratabla->g('orderby') ?>" />
    </label>
    </div>
    
    <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
     <input type="hidden" name="controller" value="traduccion" />
  <input type="hidden" name="task" value="saveConfig" />
  <input type="hidden" name="tabla" value="<?php echo $tabla ?>" />
  </div>
  </div>
</div>
</form>

