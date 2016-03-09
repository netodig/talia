<?php
import("classes.helper");
import("upload");
import('funciones');

$cods= new CodTiposExtend();

$tipocod = $_REQUEST['tipocod'];
$cnombre = $_REQUEST['nombre'];
$corden = $_REQUEST['orden'];


$titulo="Agregar ".$TIPOSCOD[$tipocod];
$cid= $_REQUEST['cid'];
$corden = 0;
$cnivel = 0;
if($cid)
{
	$cods=$cods->getCodTiposById($cid);
	if($cods[0])
	{
		$cods= $cods[0];
		$corden = $cods->g('orden');
		$cnombre = $cods->g('nombre');
        $calias = $cods->g('alias');
		$cnivel = $cods->g('nivel');
		$titulo="Editar ".$TIPOSCOD[$tipocod];
	}	
}
    
global $com;

?>

<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <a class="fr back" href="<?php echo Url::adminlink("codificador/listado","tipocod=".$tipocod) ?>">Volver a al listado</a>
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
      <div class="fl w100p"	>
        <label class="w40p" >Nombre:<br />
          <input type="text" id="nombre" size="50" name="nombre" value="<?php echo $cnombre; ?>" />
        </label>
        <label class="w40p" >Alias:<br />
          <input type="text" id="alias" size="50" name="alias" value="<?php echo $calias; ?>" />
        </label>
        <label >Orden:<br />
          <input class="num" type="text" id="orden" size="5" name="orden" value="<?php echo $corden; ?>" />
        </label>
      </div>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="savecod" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="tipocod" value="<?php echo $tipocod ?>" />
</form>

<script type="text/javascript">
	$("#formcod").validate({
		rules: {
			nombre: {"required":true},
			orden: {"number":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			orden: {"number":"Debe ser número"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
	

</script>