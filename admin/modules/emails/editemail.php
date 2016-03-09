<?
import("classes.helper");
import("upload");
import('funciones');

$email= new EmailsExtend();

$titulo="Editar email";

$cemail = "";
$cvariables = "";
$cdescripcion="";
$ctitulo =$_REQUEST['titulo'];
$ctexto =$_REQUEST['texto'];
$cemailde =$_REQUEST['emailde'];

$cid= $_REQUEST['cid'];
$cidtipo= $_REQUEST['cidtipo'];

if($cidtipo)
{
	$email=$email->getEmail($cidtipo);
	if($email[0])
	{
		$email= $email[0];
		if(!$email->g('ider'))
		{
			//la creo
			$s= new EmailsExtend();
			$s->setTipo($cidtipo);
			$s->Save();
			$cid=$s->getPkId();
		}
		
		$cemail = $email->g('nombre');
		$cvariables = $email->g('variables');
		$ctitulo = $email->g('titulo');
		$ctexto =$email->g('texto');
		$cemailde =$email->g('emailde');
		$cdescripcion=$email->g('descripcion');;
		
	}
}
global $com;

?>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/ckeditor/ckeditor.js"></script>
<form action="" method="post" id="formcliente" enctype="multipart/form-data" name="formcliente">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("emails/listadoemails") ?>">Volver al listado</a> </li>
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
      <label class="w50p">Tipo de email: <strong><?php echo $cemail ?></strong>
     </label>
      <label class="w100p">Descripción: <strong><?php echo $cdescripcion ?></strong>
     </label>
       <label class="w100p mt1p cb">Variables:  <?php echo htmlentities($cvariables) ?>
     </label>
     <label class="w100p">Email desde:<br />
        <input  type="text" size="100" id="emailde" name="emailde" value="<?php echo $cemailde; ?>" />
      </label>
      <label class="w100p">Título:<br />
        <input  type="text" size="100" id="titulo" name="titulo" value="<?php echo $ctitulo; ?>" />
      </label>
      <label class="cb w100p" >Texto:<br />
     <textarea name="texto" cols="100" rows="8" id="texto"><?php echo $ctexto ?></textarea>
      </label>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="saveemail" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="cidtipo" value="<?php echo $cidtipo ?>" />
</form>
<script type="text/javascript">
	$("#formcliente").validate({
		rules: {
			emailde: {"email":true}
			},
		messages: {
			emailde: {"email":"Email inválido"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});


var editor = CKEDITOR.replace('texto');
</script>