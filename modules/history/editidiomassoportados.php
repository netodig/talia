<?php
import("classes.helper");
import("upload");
import('funciones');

$history= new HistoryExtend();

$cnombre = $_REQUEST['nombre'];
$clanref = $_REQUEST['lanref'];
$ccreador = "";

$titulo="";
$cid= $_REQUEST['cid'];
if($cid)
{
	$history=$history->getHistoria($cid);
	if($history[0])
	{
		
		$history= $history[0];
		
		$cnombre =$history->g('nombre');
		$clanref =$history->g('idiomaref');
		$titulo= sprintf($lang->g('EDICION_IDIOMAS'),$cnombre);

	}
}
global $com;


$idiomassoport= new HistorylangExtend();
$idiomassoport=$idiomassoport->getIdiomasSoportPosible($cid,$clanref);
?>

<form action="" method="post" id="formusuario" enctype="multipart/form-data" name="formusuario">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <ul class="submenu">
    <li><a class="fr back" href="<?php echo Url::sitelink("history/edit","cid=$cid") ?>"><?php echo $lang->g('VOLVER_HISTORIA') ?></a> </li>
  </ul>
  <?php
	  if($com["message"])
	  {
    ?>
  <h2 class="<?php echo $com["clase"] ?>"><?php echo $com["message"] ?></h2>
  <?php
	 }
	 ?>
  <fieldset class="row col-md-12 fl col-xs-11" >
    <legend></legend>
    <div class="fl col-md-12 col-xs-12">
      <div class="tablediv">
    <table class="col-md-10 col-xs-12" style="margin:0 auto" border="0" cellspacing="0">
      <tr>
      	<th width="20%"><?php echo $lang->g('SOPORTADO') ?></th>
        <th width="20%"><?php echo $lang->g('IDIOMA') ?></th>
        <th width="60%"><?php echo $lang->g('TITULO') ?></th>
      </tr>
      <?php 
		$par="";
		$i=0;
		foreach($idiomassoport as $c)
		{
			$i++
		?>
      <tr class="<?php echo $par ?>" id="row<?php echo $c->g('id') ?>">
      	 <td><input name="soportado[]" type="checkbox" <?php if($c->g('idhistoria')) {?> checked="checked" <?php }?> value="<?php echo $c->g('abv') ?>" /></td>
        <td><?php echo $c->g('idioma') ?></td>
        <td><input name="idioma<?php echo $c->g('abv') ?>" value="<?php echo $c->g('nombreh') ?>" type="text"></td>
      </tr>
      <?php
		if(!$par)
		$par="par";
		else
		$par=""; 
		}
		?>
    </table>
  </div>
    </div>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="<?php echo $lang->g('GUARDAR') ?>" />
  </div>
  <input type="hidden" name="controller" value="general" />
  <input type="hidden" name="task" value="savehistorylangs" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  
</form>
<script type="text/javascript">
	$("#formusuario").validate({
		rules: {
			nombre: {"required":true},
			lanref: {"required":true},
			},
		messages: {
			nombre: {"required":"<?php echo $lang->g('DATO_REQUERIDO') ?>"},
			lanref: {"required":"<?php echo $lang->g('DATO_REQUERIDO') ?>"},
		},
		debug: true,
		errorElement: 'div',		
		submitHandler: function(form){
		
		form.submit();
		}
	});
	
	
</script>