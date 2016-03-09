<?php
import("classes.helper");
import("upload");
import('funciones');

$modulos= new PmodulosExtend();

$titulo="Agregar modulo";

$cid= $_REQUEST['cid'];
$cnombre = $_REQUEST['nombre'];
$cacceso = $_REQUEST['acceso'];
$ctipo = $_REQUEST['tipo'];


if($cid)
{
	$modulos=$modulos->getPmodulosById($cid);
	if($modulos[0])
	{
		$modulos= $modulos[0];
		$cnombre = $modulos->g('nombre');
		$cacceso = $modulos->g('acceso');
		$ctipo = $modulos->g('tipo');

		$titulo="Editar modulo";
	}	
}
    
global $com;

?>

<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li>  <a class="fr back" href="<?php echo Url::adminlink("perfiles/modulos/listado") ?>">Volver a al listado <i class="fa fa-arrow-left"></i></a></li>
  </ul>
  
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
          <label >Nombre:<br />
            <input type="text" id="nombre" size="30" name="nombre" value="<?php echo $cnombre ?>" />
          </label>
           <label >Acceso:<br />
            <input type="text" id="acceso" size="30" name="acceso" value="<?php echo $cacceso ?>" />
          </label>
           <label >Tipo:<br />
      	   <?php 
		   $TIPOS= array();
		   $TIPOS=array("1"=>"Admin","2"=>"Front");

		   echo THelper::select('tipo', $TIPOS, $ctipo,false);
		   ?>
          </label>
      </div>
    </fieldset>
  </div>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="usuarios" />
  <input type="hidden" name="task" value="savemodulo" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
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
<div class="fl w100p">
<?php 
if($cid)
{
	include("listadotask.php");
}

?>
</div>