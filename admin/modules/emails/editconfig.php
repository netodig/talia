<?
import("classes.helper");
import("upload");
import('funciones');

$email= new EmailsPlantillaExtend();

$cnombre = $_REQUEST['nombre'];
$cvariables = $_REQUEST['variables'];
$ccode =$_REQUEST['code'];
$cdescripcion=$_REQUEST['descripcion'];

$titulo="Agregar email";

$cid= $_REQUEST['cid'];
if($cid)
{
	$email=$email->getEmailsPlantillaById($cid);
	if($email[0])
	{
		$email= $email[0];
		
		$cnombre =$email->g('nombre');
		$cvariables = $email->g('variables');
		$ccode =$email->g('code');
		$cdescripcion=$email->g('descripcion');

		$titulo="Editar email";
	}
}
global $com;

?>

<form action="" method="post" id="formcliente" enctype="multipart/form-data" name="formcliente">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("emails/emailsconfig") ?>">Volver al listado</a> </li>
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
      <label class="w50p">Código:<br />
        <input name="code"  type="text" id="code" value="<?php echo $ccode; ?>" size="10" maxlength="8" />
      </label>
      <label class="cb w50p" >Variables:<br />
     <textarea name="variables" cols="100" rows="3" id="variables"><?php echo $cvariables ?></textarea>
      </label>
      
       <label class="cb w50p" >Explicación:<br />
     <textarea name="descripcion" cols="100" rows="3" id="descripcion"><?php echo $cdescripcion ?></textarea>
      </label>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="saveemailconfig" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
</form>
<script type="text/javascript">
	$("#formcliente").validate({
		rules: {
			nombre: {"required":true},
			code: {"required":true},
			variables: {"required":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			code: {"required":"Código requerido"},
			variables: {"required":"Variables requeridas"}
			
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});


</script>