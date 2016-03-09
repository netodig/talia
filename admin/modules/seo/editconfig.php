<?
import("classes.helper");
import("upload");
import('funciones');

$seo= new SeoConfigExtend();

$cnombre = $_REQUEST['nombre'];
$cvariables = $_REQUEST['variables'];
$cmodulo =$_REQUEST['modulo'];

$titulo="Agregar modulo";

$cid= $_REQUEST['cid'];
if($cid)
{
	$seo=$seo->getSeoConfigById($cid);
	if($seo[0])
	{
		$seo= $seo[0];
		
		$cnombre =$seo->g('nombrepagina');
		$cvariables = $seo->g('variables');
		$cmodulo =$seo->g('module');

		$titulo="Editar modulo";
	}
}
global $com;

?>

<form action="" method="post" id="formcliente" enctype="multipart/form-data" name="formcliente">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("seo/seoconfig") ?>">Volver al listado</a> </li>
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
      <label class="w50p">Nombre:<br />
        <input type="text" id="nombre" size="50" name="nombre" value="<?php echo $cnombre; ?>" />
      </label>
      <label class="w50p">Modulo:<br />
        <input  type="text" size="50" id="modulo" name="modulo" value="<?php echo $cmodulo; ?>" />
      </label>
      <label class="cb w50p" >Variables:<br />
     <textarea name="variables" cols="100" rows="3" id="variables"><?php echo $cvariables ?></textarea>
      </label>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="saveseoconfig" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
</form>
<script type="text/javascript">
	$("#formcliente").validate({
		rules: {
			nombre: {"required":true},
			modulo: {"required":true},
			variables: {"required":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			modulo: {"required":"Modulo requerido"},
			variables: {"required":"Variables requerido"}
			
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});


</script>