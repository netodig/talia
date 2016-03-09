<?php
import("classes.helper");
import("upload");
import('funciones');

$perfil= new PerfilesExtend();

$titulo="Agregar perfil";

$cid= $_REQUEST['cid'];
$cnombre = $_REQUEST['nombre'];

if($cid)
{
	$perfil=$perfil->getPerfilesById($cid);
	if($perfil[0])
	{
		$perfil= $perfil[0];
		$cnombre = $perfil->g('nombre');

		$titulo="Editar perfil";
	}	
}
    
global $com;

?>
<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
<h1 class="fl"><?php echo $titulo ?></h1>
<a class="fr back" href="<?php echo Url::adminlink("perfiles/perfiles/listado") ?>">Volver a al listado</a>
<?
	  if($com["message"])
	  {
    ?>
<h2 class="<?php echo $com["clase"] ?>"><? echo $com["message"] ?></h2>
<?
	 }
	 ?>
<div class="fl w100p">
  <fieldset class="w100p fl" >
    <legend></legend>
    <div class="fl w100p">
      <div class="fl w100p">
        <label >Nombre:<br />
          <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre ?>" />
        </label>
      </div>
    </div>
  </fieldset>
</div>
<div class="w100p tc fl">
  <input class="cb" type="Submit" name="Submit" value="Guardar" />
</div>
<input type="hidden" name="controller" value="usuarios" />
<input type="hidden" name="task" value="saveperfil" />
<input type="hidden" name="cid" value="<?php echo $cid ?>" />
<?php if($cid)
  {
	  ?>
<div class="fl w100p">
	<?php
	  // include("permisos.php");
	   ?>
</div>
<?
  }
  ?>
</form>
<script type="text/javascript">
	$("#formcod").validate({
		rules: {
			nombre: {"required":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"}
		
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
	
</script>