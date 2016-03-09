<?php
import("classes.helper");
import("upload");
import('funciones');

$tareas= new PmodulosTaskExtend();

$titulo="Agregar tarea de modulo";

$cid= $_REQUEST['cid'];
$cnombre = $_REQUEST['nombre'];
$ctask = $_REQUEST['taske'];
$ctipo = $_REQUEST['tipo'];

$idmodulo = $_REQUEST['idmodulo'];

if($cid)
{
	$tareas=$tareas->getPmodulosTaskById($cid);
	if($tareas[0])
	{
		$tareas= $tareas[0];
		$cnombre = $tareas->g('nombre');
		$ctask = $tareas->g('task');
		$ctipo = $tareas->g('tipo');
		$idmodulo = $tareas->g('idmodulo');

		$titulo="Editar tarea de modulo";
	}	
}
    
global $com;

?>

<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li>  <a class="fr back" href="<?php echo Url::adminlink("perfiles/modulos/edit","cid=$idmodulo") ?>">Volver a al listado <i class="fa fa-arrow-left"></i></a></li>
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
        <label >Tarea:<br />
          <input type="text" id="taske" size="30" name="taske" value="<?php echo $ctask ?>" />
        </label>
        <label >Tipo:<br />
          <?php 
		   $TIPOS= array();
		   $TIPOS=array("1"=>"Vista","2"=>"Controlador");

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
  <input type="hidden" name="task" value="savetaremodulo" />
  <input type="hidden" name="idmodulo" value="<?php echo $idmodulo ?>" />
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

