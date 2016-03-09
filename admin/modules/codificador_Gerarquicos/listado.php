<?php
import("classes.helper");
import("upload");
import('funciones');

$tipocod= $_REQUEST['tipocod'];
$cid= $_REQUEST['cid'];
$txt="hijos";

$cnombret= $_REQUEST['nombret'];

$corden=$_REQUEST['corden'];
$orden=$_REQUEST['orden'];

if(!$orden)
$orden="asc";

$functionpagina="listado";

if(!$cid)
{
    $cid=0;
    $cod_nivel = new CodNivelExtend();
    $desc_nivel=$cod_nivel->getNombreNivelPadre($tipocod);
    if($desc_nivel)
    {
  
       $txt=$desc_nivel->g('nombre');
    }
}
else
{
	$cods= new CodTiposExtend();
	$cods=$cods->getById($cid);
	
	$functionpagina="edit";
    $cod_nivel = new CodNivelExtend();
    //$desc_nivel=$cod_nivel->getNombreNivel($cid);
	
	$nivel=$cods->g('nivel');
	$nivel=$nivel+1;
	
    $desc_nivel=$cod_nivel->getNombreNivelHijo($tipocod,$nivel);
	if($desc_nivel)
       {$txt=$desc_nivel->g('nombre');}
}
global $com;

$titulo="Listado de ".$txt;

$current_page = $_GET["page"] != "" ? $_GET["page"] - 1 : 0 ;   
$next_recs = $current_page * MAX_REGISTROS_PAGE;
$rowLocal =   MAX_REGISTROS_PAGE; 
$limit = "limit $next_recs, $rowLocal";

?>

<h1><?php echo $titulo ?></h1>
<div class="tablediv">
  <h2 class="fl">
    <?php //echo $cod["title"]; ?>
  </h2>
  <?php if($Acl->has("codificador_Gerarquicos/listado",'add')){?>
  <a href="<?php echo Url::adminlink('codificador_Gerarquicos/edit',"tipocod=$tipocod&idpadre=$cid") ?>" class="fr add">Agregar nuevo</a>
  <?php 
  }
  
	  $cods = new CodTiposExtend();
	  $codsList=$cods->getTiposGerarq($cid,$tipocod,$cnombret,$orden,$corden,$limit);
	  $total= $cods->getRegistrosCalculados(); 
	  $par="";
	  
	  if($corden)
	  {
	  if($orden=="asc")
	  $orden="desc";
	  else
	  $orden="asc";
	  }
  ?>
  <form action="" method="post" id="formfiltros" enctype="multipart/form-data" name="formfiltros">
    <fieldset class="w100p fl" >
      <legend>Busqueda por:</legend>
      <div class="fl w100p">
        <label class="mr2p" >Nombre:<br />
          <input type="text" id="nombret" size="30" name="nombret" value="<?php echo $cnombret; ?>" />
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
        <th width="30%" ><a href="<?php echo Url::adminlink("codificador_Gerarquicos/$functionpagina","tipocod=$tipocod&cid=$cid&cnombret=$cnombret&orden=$orden&corden=nombre&registros=$reg") ?>">Nombre</a></th>
        <th width="30%">Alias</th>
        <th width="10%"><a href="<?php echo Url::adminlink("codificador_Gerarquicos/$functionpagina","tipocod=$tipocod&cid=$cid&cnombret=$cnombret&orden=$orden&corden=orden&registros=$reg") ?>">Orden</a></th>
        <th colspan="2">Opciones</th>
      </tr>
      <?php 
	  	
		
		

		foreach($codsList as $c)
		{
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
        <td><?php echo $c->g('id') ?></td>
        <td><?php echo $c->g('nombre') ?></td>
        <td><?php echo $c->g('alias') ?></td>
        <td><?php echo $c->g('orden') ?></td>
        <td><?php if($Acl->has("codificador_Gerarquicos/listado",'edit')){?>
          <a href="<?php echo Url::adminlink("codificador_Gerarquicos/edit","tipocod=".$tipocod."&cid=".$c->g('id')) ?>" class="mod"></a></td>
        <?
		}
		?>
        <td><?php if($Acl->has("codificador_Gerarquicos/listado",'del')){?>
          <a href="javascript:void(0)" onclick="delcodgerq(<?php echo $c->g('id') ?>)" class="del"></a>
          <?
		}
		?></td>
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
   $pages->querystring="&module=codificador_Gerarquicos/$functionpagina&tipocod=$tipocod&cid=$cid&cnombret=$cnombret&orden=$orden&corden=$corden";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
