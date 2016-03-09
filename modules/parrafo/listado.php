<?php
import("classes.helper");
import('funciones');

$cid= $_REQUEST['cid'];
$history= new HistoryExtend();
$clanref ="en";
$titulo="";

if($cid)
{
	$history=$history->getHistoria($cid);
	if($history[0])
	{
		$history= $history[0];
		$cnombre =$history->g('nombre');
		$clanref =$history->g('idiomaref');
		$titulo=sprintf($lang->g('LISTADO_PARRAFOS'),$cnombre);

	}
}

$corden=$_REQUEST['corden'];
$orden=$_REQUEST['orden'];

if(!$orden)
$orden="asc";

global $com;

$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

?>


<h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
  	
    <li><a class="fr back" href="<?php echo Url::sitelink("history/edit","cid=$cid") ?>"><?php echo $lang->g('VOLVER_HISTORIA') ?></a> </li>
  </ul>
  
<?php
  Msg::show();

  $parrafos= new ParrafoExtend();
  $listParrafos=$parrafos->getParrafos($cid,$clanref ,$orden,$corden,$limit);
  $total= $parrafos->getRegistrosCalculados(); 
  
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
  <?php if($Acl->has("parrafo/listado",'add')){?>
  <a href="<?php echo Url::sitelink("parrafo/edit","cidh=$cid") ?>" class="fr add"><?php echo $lang->g('AGREGAR_NUEVO'); ?></a>
  <?
 }
 ?>
  <!--<form action="" method="post" id="formfiltros" enctype="multipart/form-data" name="formfiltros">
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
  </form>-->
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="70%" ><?php echo $lang->g('PARRAFO') ?></th>
        <th width="15%"><?php echo $lang->g('CANT_ORACIONES') ?></th>
        <th width="15%" colspan="2"><?php echo $lang->g('OPCIONES') ?></th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($listParrafos as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
        <td><?php echo substr($c->g('texto'),0,200) ?>...</td>
        <td><?php echo $c->g('cantoraciones') ?></td>
        <td><?php if($Acl->has("parrafo/listado",'edi')){?>
          <a href="<?php echo Url::sitelink("parrafo/edit","cid=".$c->g('id')."&cidh=$cid") ?>" class="mod"></a>
          <? }?></td>
        <td><?php if($Acl->has("parrafo/listado",'del')){?>
          <a href="javascript:void(0)" onclick="delparrafo(<?php echo $c->g('id') ?>)" class="del"></a>
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
  $pages->querystring="&module=parrafo/listado&idiomaref=$ctipo&nombre=$cnombre&corden=$corden&orden=$orden";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
