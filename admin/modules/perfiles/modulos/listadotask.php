<?
import("classes.helper");
import("upload");
import('funciones');

global $com;
$titulo="Listado de tareas del modulo";



$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

$TIPOS=array("1"=>"Vista","2"=>"Controlador");

?>

<h1><?php echo $titulo ?></h1>
<?
	  if($com["message"])
	  {
    ?>
<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
<?
	 }

  $tareas= new PmodulosTaskExtend();
  $tareaslist=$tareas->getmodulos($cid);
  $total=$tareas->getRegistrosCalculados();
  
  ?>
<div class="tablediv">
<a href="<?php echo Url::adminlink('perfiles/modulos/edittask',"idmodulo=$cid") ?>" class="fr add">Agregar nueva <i class="fa fa-plus"></i></a>
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="20%">Nombre</th>
        <th width="20%">Tarea</th>
        <th width="20%">Tipo</th>
        <th width="10%" colspan="2">Opciones</th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($tareaslist as $s)
		{
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $s->g('id') ?>">
        <td><?php echo $s->g('nombre') ?></td>
        <td><?php echo $s->g('task') ?></td>
        <td><?php echo $TIPOS[$s->g('tipo')] ?></td>
        <td><?php ?><a href="<?php echo Url::adminlink("perfiles/modulos/edittask","cid=".$s->g('id')) ?>" class="mod"></a></td>
        <td><a href="javascript:void(0)" onclick="deltaske(<?php echo $s->g('id') ?>)" class="del"></a></td>
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
  <div class="paginator">
    <? /*
  $pages = new Paginator;
  $pages->items_per_page = MAX_REGISTROS_PAGE;
  $pages->items_total = $total;   
  $pages->mid_range = MAX_LINKS_PAGE;
  $pages->querystring="&module=perfiles/modulos/listado";
  $pages->paginate();   
  echo $pages->display_pages();  */
  ?>
  </div>
</div>
