<?php
import("classes.helper");
import('funciones');

$ctexto = $_REQUEST['textop'];
$clanref ="en";

$titulo="";

$cidhistory= $_REQUEST['cidh'];
$history= new HistoryExtend();
$titulo="";
if($cidhistory)
{
	$history=$history->getHistoria($cidhistory);
	if($history[0])
	{
		$history= $history[0];
		$cnombre =$history->g('nombre');
		$clanref =$history->g('idiomaref');
		$titulo=sprintf($lang->g('AGREGAR_PARRAFO'),$cnombre);
	}
}

$parrafo= new ParrafoExtend();
$cid= $_REQUEST['cid'];
if($cid)
{
	$parrafo=$parrafo->getById($cid);
	if($parrafo)
	{
	
		$ctexto =$parrafo->g('texto');
		$titulo=sprintf($lang->g('EDITAR_PARRAFO'),$cnombre);

	}
}
global $com;

?>

<form action="" method="post" id="formusuario" enctype="multipart/form-data" name="formusuario">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
  	<li><a class="fr back" href="<?php echo Url::sitelink("history/edit","cid=$cidh") ?>"><?php echo $lang->g('VOLVER_HISTORIA') ?></a> </li>
    <li><span class="separator">|</span></li>
    <li><a class="fr back" href="<?php echo Url::sitelink("parrafo/listado","cid=$cidh") ?>"><?php echo $lang->g('VOLVER_LISTADO') ?></a> </li>
  </ul>
  <?php
  Msg::show();
  ?>
  <fieldset class="row col-md-12 fl" >
    <legend></legend>
    <div class="fl col-md-6">
      <label class="w100p" >
      	<?php echo $lang->g('TEXTO_PARRAFO') ?>
        <br />
        <textarea name="textop" id="textop" class="w100p" cols="" rows="6"><?php echo $ctexto ?></textarea>
      </label>
    </div>
    <div class="fl col-md-5">
      <?php 
	  if($cid)
	  {
		  $clang=$clanref; 
		  include("oraciones.php");
	  }
	  ?>
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="<?php echo $lang->g('GUARDAR') ?>" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="saveparrafo" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="cidh" value="<?php echo $cidhistory ?>" />
</form>
<script type="text/javascript">
	$("#formusuario").validate({
		rules: {
			textop: {"required":true}
			},
		messages: {
			textop: {"required":"<?php echo $lang->g('DATO_REQUERIDO') ?>"}
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
</script>