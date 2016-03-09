<?php
import("classes.helper");
import("upload");
import('funciones');

$titulo="Listado de idiomas";

?>
<h1><?php echo $titulo ?></h1>
<?php
	  if($com["message"])
	  {
?>
<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
	<?
	 }
	 ?>
<div class="tablediv">
  <h2 class="fl"><?php echo $cod["title"] ?></h2>
  <a href="<?php echo Url::adminlink('traduccion/idioma/edit') ?>" class="fr add">Agregar nuevo <i class="fa fa-plus"></i></a>
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="10%">Id</th>
        <th width="50%">Nombre</th>
        <th width="15%">Abreviatura</th>
        <th width="15%">Activo</th>
        <th colspan="2">Opciones</th>
      </tr>
      <?php 
	  	$idioma = new IdiomasTExtend();
		$idiomaList=$idioma->getIdiomasAdmin();
                $total= $idioma->getRegistrosCalculados(); 
		$par="";
		foreach($idiomaList as $c)
		{
                    $id = $c->g('id');  
                    $act = $c->g('activo');
                    $act_txt="No";
                    if($act)
                    {
                        $act_txt="Si";
                    }
     ?>
      <tr class="<?php echo $par ?>" id="row<?php echo $id ?>">
       <td><?php echo $id ?></td>
        <td><?php echo $c->g('nombre') ?></td>
         <td><?php echo $c->g('abv') ?></td>
         <td><?php echo $act_txt ?></td>
        <td><a href="<?php echo Url::adminlink("traduccion/idioma/edit","id=".$id) ?>" class="mod"></a></td>
        <td><a href="javascript:void(0)" onclick="delidioma(<?php echo $id ?>)" class="del"></a></td>
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
   $pages->querystring="&module=traduccion/idioma/listado";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
