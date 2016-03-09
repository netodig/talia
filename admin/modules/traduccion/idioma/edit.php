<?php
import("classes.helper");
import("upload");
import('funciones');

global $com;

$titulo="Agregar idioma del sitio";


$id= $_REQUEST['id'];

if($id)
{
        $idioma= new IdiomasTExtend();
	$idioma=$idioma->getById($id);
	if($idioma)
	{
            $nombre = $idioma->g('nombre');
            $abv = $idioma->g('abv');
            $act = $idioma->g('activo');
            $titulo="Editar idioma : $cnombre";
	}	
}    
?>

<form action="" method="post" id="formcod" enctype="multipart/form-data" name="formcod">
    <h1 class="fl"><?php echo $titulo ?></h1>
    <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::adminlink("traduccion/idioma/listado","") ?>">Volver al listado <i class="fa fa-arrow-left"></i></a> </li>
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
      <div class="fl w100p"	>
        <label class="w40p" >Nombre:<br />
          <input type="text" id="nombre" size="50" name="nombre" value="<?php echo $nombre; ?>" />
        </label>
        <label class="w40p" >Abreviatura:<br />
          <input type="text" id="abv" size="50" name="abv" value="<?php echo $abv; ?>" />
        </label>
        <label >Activo:<br />
            <input type="checkbox" id="act" size="5" name="act" <?php if ($act){?> checked="checked" <? } ?> />
        </label>
      </div>
      
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="traduccion" />
  <input type="hidden" name="task" value="saveidioma_t" />
  <input type="hidden" name="id" value="<?php echo $id ?>" />
</form>
<script type="text/javascript">
	$("#formcod").validate({
		rules: {
			nombre: {"required":true},
			abv: {"required":true}
			},
		messages: {
			nombre: {"required":"Nombre requerido"},
			orden: {"required":"Abreviatura requerida"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
</script>