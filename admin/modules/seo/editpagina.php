<?
import("classes.helper");
import("upload");
import('funciones');

$seo= new SeoConfigExtend();

$titulo="Editar título y descripción de página";

$cpagina = "";
$cvariables = "";
$ctitulo =$_REQUEST['titulo'];
$cdescripcion =$_REQUEST['descripcion'];

$cid= $_REQUEST['cid'];
$cidtipo= $_REQUEST['cidtipo'];

if($cidtipo)
{
	$seo=$seo->getPagina($cidtipo);
	if($seo[0])
	{
		$seo= $seo[0];
		if(!$seo->g('idss'))
		{
			//la creo
			$s= new SeoExtend();
			$s->setTipo($cidtipo);
			$s->Save();
			$cid=$s->getPkId();
		}
		
		$cpagina = $seo->g('nombrepagina');
		$cvariables = $seo->g('variables');
		$ctitulo = $seo->g('titulo');
		$cdescripcion =$seo->g('descripcion');
	}
}
global $com;

?>

<form action="" method="post" id="formcliente" enctype="multipart/form-data" name="formcliente">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("seo/listadopaginas") ?>">Volver al listado</a> </li>
  </ul>
  <?
	  if($com["message"])
	  {
    ?>
  <h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
  <?
	 }
	 ?>
  <fieldset class="w100p fl" >
    <legend></legend>
    <div class="fl w100p">
      <label class="w50p">Página: <strong><?php echo $cpagina ?></strong>
     </label>
       <label class="w100p cb">Variables:  <?php echo htmlentities($cvariables) ?>
     </label>
      <label class="w100p">Título:<br />
        <input  type="text" size="100" id="titulo" name="titulo" value="<?php echo $ctitulo; ?>" /><div id="chars">0</div>
      </label>
      <label class="cb w100p" >Descripción:<br />
     <textarea name="descripcion" cols="100" rows="3" id="descripcion"><?php echo $cdescripcion ?></textarea><div id="chars2">0</div>
      </label>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="savepaginaseo" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="cidtipo" value="<?php echo $cidtipo ?>" />
</form>
<script type="text/javascript">
	$("#formcliente").validate({
		rules: {

			},
		messages: {

		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});

$(document).ready( function() {
	
var elem = $("#chars");
$("#titulo").limiter(1500, elem);

var elem = $("#chars2");
$("#descripcion").limiter(4500, elem);

});


</script>