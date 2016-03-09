<?php
import("classes.helper");
import("upload");
import('funciones');

$tipocod= $_REQUEST['tipocod'];

global $com;

$titulo="Listado de ".$TIPOSCOD[$tipocod];

$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

$cnombre=$_REQUEST['nombre'];

$corden=$_REQUEST['corden'];
$orden=$_REQUEST['orden'];

if(!$orden)
$orden="asc";

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
	$cods = new CodTiposExtend();
	$codsList= 	$cods->getTipos($tipocod,$cnombre,$orden,$corden,$limit);
	$total= $cods->getRegistrosCalculados(); 
	
	 if($corden)
	  {
	  if($orden=="asc")
	  $orden="desc";
	  else
	  $orden="asc";
	  }
  ?>   
     
<div class="tablediv">
  <h2 class="fl"><?php echo $cod["title"] ?></h2>
  <a href="<?php echo Url::adminlink('codificador/edit',"tipocod=$tipocod") ?>" class="fr add">Agregar nuevo</a>
  <form action="" method="post" id="formfiltros" enctype="multipart/form-data" name="formfiltros">
    <fieldset class="w100p fl" >
      <legend>Busqueda por:</legend>
      <div class="fl w100p">
        <label class="mr2p" >Nombre:<br />
          <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre; ?>" />
        </label>
      </div>
      <div class="w100p tc fl">
        <input class="cb" type="Submit" name="Submit" value="Buscar" />
      </div>
    </fieldset>
  </form>
  <div class="tablediv">
    <table width="100%" border="0" cellspacing="0">
      <tr>
        <th width="10%">Id</th>
        <th width="30%"><a href="<?php echo Url::adminlink("codificador/listado","tipocod=$tipocod&nombre=$cnombre&orden=$orden&corden=nombre") ?>">Nombre</a></th>
        <th width="30%">Alias</th>
        <th width="10%"><a href="<?php echo Url::adminlink("codificador/listado","tipocod=$tipocod&nombre=$cnombre&orden=$orden&corden=orden") ?>">Orden</a></th>
        <th colspan="2">Opciones</th>
      </tr>
      <?php 
	  	
		$par="";
		
		foreach($codsList as $c)
		{
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
       <td><?php echo $c->g('id') ?></td>
        <td><?php echo $c->g('nombre') ?></td>
         <td><?php echo $c->g('alias') ?></td>
         <td><?php echo $c->g('orden') ?></td>
        <td><a href="<?php echo Url::adminlink("codificador/edit","tipocod=".$tipocod."&cid=".$c->g('id')) ?>" class="mod"></a></td>
        <td><a href="javascript:void(0)" onclick="delcod(<?php echo $c->g('id') ?>)" class="del"></a></td>
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
   $pages->querystring="&module=codificador/listado&tipocod=$tipocod&nombre=$cnombre&orden=$orden&corden=$corden";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
