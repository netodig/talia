<?php
import("classes.helper");
import("upload");
import('funciones');

$cidiomaref=$_REQUEST['idiomaref'];
$cnombre=$_REQUEST['nombre'];

$corden=$_REQUEST['corden'];
$orden=$_REQUEST['orden'];

if(!$orden)
$orden="asc";


global $com;
$titulo=$lang->g('LISTADO_HISTORIAS');

$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

?>

<h1><?php echo $titulo ?></h1>
<?php
	  if($com["message"])
	  {
    ?>
<h2 class="<?php echo $com["clase"] ?>"><?php echo $com["message"] ?></h2>
<?php
	 }
	 ?>
<?php 
  $historias= new HistoryExtend();
  $listHistorias=$historias->getHistorias($cnombre,$cidiomaref,$orden,$corden,$limit);
  $total= $historias->getRegistrosCalculados(); 
  
  $ordenes=array();
  $ordenes["h.nombre"]=' <i class="fa fa-sort"></i>';
  $ordenes["idiomaref"]=' <i class="fa fa-sort"></i>';
  
  $ordenes[$corden]=' <i class="fa fa-sort-'.$orden.'"></i>';
  
    if($corden)
	  {
	  if($orden=="asc")
	  $orden="desc";
	  else
	  $orden="asc";
	  }
  ?>
<div class="tablediv">
  <?php if($Acl->has("history/listado",'add')){?>
  <a href="<?php echo Url::sitelink("history/edit") ?>" class="fr add"><?php echo $lang->g('AGREGAR_NUEVO'); ?></a>
  <?
 }
 ?>
  <form action="" method="post" id="formfiltros" enctype="multipart/form-data" name="formfiltros">
    <fieldset class="row col-md-12 fl" >
      <legend><?php echo $lang->g('BUSQUEDA_POR'); ?>:</legend>
      <div class="fl col-md-12">
        <label class="mr2p" ><?php echo $lang->g('NOMBRE'); ?>:<br />
          <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre; ?>" />
        </label>
        <label class="mr2p" ><?php echo $lang->g('IDIOMA_REFERENCIA'); ?>:<br />
          <?php 
			$idiomasref= new IdiomasTExtend();
			$idiomasref=$idiomasref->getIdiomas();
			$idiref= array();
			$idiref[""]=$lang->g('SELECCIONAR');
			foreach($idiomasref as $p)
			{
				$idiref[$p->g('abv')]=$p->g('nombre');
			}
			
			echo THelper::select('idiomaref', $idiref, $cidiomaref,false);
			?>
        </label>
      </div>
      <div class="col-md-12 tc">
        <input class="cb" type="Submit" name="Submit" value="<?php echo $lang->g('BUSCAR') ?>" />
      </div>
    </fieldset>
  </form>
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="15%" colspan="2"><a href="<?php echo Url::sitelink("history/listado","idiomaref=$idiomaref&nombre=$cnombre&corden=h.nombre&orden=$orden") ?>"><?php echo $lang->g('NOMBRE') ?> <?php echo $ordenes['h.nombre'] ?></a></th>
        <th width="15%"><a href="<?php echo Url::sitelink("history/listado","idiomaref=$cidiomaref&nombre=$cnombre&corden=idiomaref&orden=$orden") ?>"><?php echo $lang->g('IDIOMA_REFERENCIA') ?> <?php echo $ordenes['idiomaref'] ?></a></th>
        <th width="10%" colspan="2"><?php echo $lang->g('OPCIONES') ?></th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($listHistorias as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
        <td><?php 
		  $fotop="sinimagen.png";
		  
		  if($c->g('nombrearchivo'))
		  $fotop=$c->g('nombrearchivo');
		  ?>
          <a class="gallery-item" title="" href="<?php echo Url::thumfoto2("historia",$fotop,800,800) ?>"> <img src="<?php echo Url::thumfoto2("historia",$fotop,30,30) ?>" /> </a></td>
        <td><?php echo $c->g('nombre') ?></td>
        <td><?php echo $idiref[$c->g('idiomaref')] ?></td>
        <td><?php if($Acl->has("history/listado",'edi')){?>
          <a href="<?php echo Url::sitelink("history/edit","cid=".$c->g('id')) ?>" class="mod"></a>
          <? }?></td>
        <td><?php if($Acl->has("history/listado",'del')){?>
          <a href="javascript:void(0)" onclick="delhistory(<?php echo $c->g('id') ?>)" class="del"></a>
          <? }?></td>
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
    <?php
  $pages = new Paginator;
  $pages->items_per_page = MAX_REGISTROS_PAGE;
  $pages->items_total = $total;   
  $pages->mid_range = MAX_LINKS_PAGE;
  $pages->querystring="&module=history/listado&idiomaref=$ctipo&nombre=$cnombre&corden=$corden&orden=$orden";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
<script type="text/javascript">

$('.gallery-item').magnificPopup({
  type: 'image',
  tLoading:'Cargando...',
  tClose:'Cerrar',
  gallery:{
    enabled:true,
	tPrev: 'Anterior',
	tNext: 'Siguiente',
	tCounter: '<div class="mfp-counter">%curr% de %total%</div>'

	
  }
});

</script>