<?
import("classes.helper");
import("upload");
import('funciones');

global $com;
$titulo="Listado de emails";

$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

?>

<h1><?php echo $titulo ?></h1>
<?
	  if($com["message"])
	  {
    ?>
<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
<?
	 }
	 ?>
<?php 
  $emails= new EmailsPlantillaExtend();
  $emaillist=$emails->getListado($limit);
  $total=$emails->getRegistrosCalculados();
  
  ?>
<div class="tablediv"> <a href="<?php echo Url::adminlink("emails/editconfig") ?>" class="fr add">Agregar nuevo</a>
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="30%">Nombre</th>
        <th width="20%">Código</th>
        <th width="30%">Variables</th>
        <th width="10%">Opciones</th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($emaillist as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
        <td><?php echo $c->g('nombre') ?></td>
        <td><?php echo $c->g('code') ?></td>
        <td><?php echo htmlentities($c->g('variables')) ?></td>
        <td><a href="<?php echo Url::adminlink("emails/editconfig","cid=".$c->g('id')) ?>" class="mod"></a></td>
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
    <?
  $pages = new Paginator;
  $pages->items_per_page = MAX_REGISTROS_PAGE;
  $pages->items_total = $total;   
  $pages->mid_range = MAX_LINKS_PAGE;
  $pages->querystring="&module=seo/seoconfig";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
