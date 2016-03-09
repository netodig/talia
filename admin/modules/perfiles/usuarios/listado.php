<?
import("classes.helper");
import("upload");
import('funciones');

$ctipo=$_REQUEST['tipo'];
$cnombre=$_REQUEST['nombre'];

$corden=$_REQUEST['corden'];
$orden=$_REQUEST['orden'];

if(!$orden)
$orden="asc";


global $com;
$titulo="Listado de Usuarios";

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
  $usuarios= new UserinterExtend();
  $listUsuarios=$usuarios->getUsuarios($cnombre,$ctipo,$orden,$corden,$limit);
  $total= $usuarios->getRegistrosCalculados(); 
  
    if($corden)
	  {
	  if($orden=="asc")
	  $orden="desc";
	  else
	  $orden="asc";
	  }
  ?>
<div class="tablediv">
 <?php if($Acl->has("perfiles/usuarios/listado",'add')){?>
 <a href="<?php echo Url::adminlink("perfiles/usuarios/edit") ?>" class="fr add">Agregar nuevo</a>
 <?
 }
 ?>
<form action="" method="post" id="formfiltros" enctype="multipart/form-data" name="formfiltros">
    <fieldset class="w100p fl" >
      <legend>Busqueda por:</legend>
      <div class="fl w100p">
        <label class="mr2p" >Nombre:<br />
          <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre; ?>" />
        </label>
        <label class="mr2p" >Perfil:<br />
         	<?php 
			$perfiles= new PerfilesExtend();
			$perfiles=$perfiles->getperfiles();
			$perfs= array();
			$perfs[""]="Seleccionar";
			foreach($perfiles as $p)
			{
				$perfs[$p->g('id')]=$p->g('nombre');
			}
			
			echo THelper::select('tipo', $perfs, $ctipo,false);
			?>
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
      	<th width="15%"><a href="<?php echo Url::adminlink("perfiles/usuarios/listado","tipo=$ctipo&nombre=$cnombre&corden=u.nombre&orden=$orden") ?>">Nombre</a></th>
        <th width="15%"><a href="<?php echo Url::adminlink("perfiles/usuarios/listado","tipo=$ctipo&nombre=$cnombre&corden=perfil&orden=$orden") ?>">Perfil</a></th>
        <th width="15%">Nombre de usuario</th>
        <th width="15%">Email de usuario</th>
        <th width="10%" colspan="2">Opciones</th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($listUsuarios as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
      
      <td><?php echo $c->g('nombre') ?> <?php echo $c->g('apellidos') ?></td>
      <td><?php echo $c->g('perfil') ?></td>
        <td><?php echo $c->g('name') ?></td>
     
        <td><?php echo $c->g('email') ?></td>
        <td>
        <?php if($Acl->has("perfiles/usuarios/listado",'edi')){?>
        <a href="<?php echo Url::adminlink("perfiles/usuarios/edit","cid=".$c->g('id')) ?>" class="mod"></a><? }?>
        </td>
        <td>
         <?php if($Acl->has("perfiles/usuarios/listado",'del')){?>
        <a href="javascript:void(0)" onclick="deluser(<?php echo $c->g('id') ?>)" class="del"></a><? }?></td>
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
  $pages->querystring="&module=perfiles/usuarios/listado&tipo=$ctipo&nombre=$cnombre&corden=$corden&orden=$orden";
  $pages->paginate();   
  echo $pages->display_pages();  
  ?>
  </div>
</div>
