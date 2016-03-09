<?
import("classes.helper");
import("upload");
import('funciones');
import("classes.jsonclass");

$tabla=$_REQUEST['tabla'];
$cid=$_REQUEST['cid'];
$idorigi=$_REQUEST['idorigi'];
$idi=$_REQUEST['idi'];

$camposEditor=array();

$elementos=new TraduccionTablasExtend();
$elementos=$elementos->getElementos();
  
$idelems= array();
$idelems[""]="Seleccionar";

foreach($elementos as $e)
{
 $idelems[$e->g('nombretabla')]=$e->g('campoid');
}

//busco los campos de esa tabla que se traducen
$camposTabla= new TraduccionExtend();
$camposTabla=$camposTabla->getCamposTabla($tabla);

//busco el dato original
$objetoorigigal= new TraduccionExtend();
$objetoorigigal= $objetoorigigal->getOriginal($tabla,$idorigi,$idelems[$tabla]);
$objetoorigigal=$objetoorigigal[0];

$titulo="Traducir";

$traducido= new TraduccionExtend();
$campotraducido=array();

$cid= $_REQUEST['cid'];
if($cid)
{
	$traducido=$traducido->getTraduccionById($cid);
	if($traducido[0])
	{
		$traducido= $traducido[0];
		$campotraducido=$traducido->g('traduccion');
		$campotraducido =  str_replace("rnttt",'', $campotraducido);
        $campotraducido =  str_replace("rntt",'', $campotraducido);
        $campotraducido =  str_replace("rnt",'', $campotraducido);
		$campotraducido =  str_replace("rnrn",'', $campotraducido);
        $campotraducido =  str_replace("rn",'', $campotraducido);
		
		
		$json= new JSON();
		
		$campotraducido=json_decode($campotraducido);
	
	}
	
}

global $com;

?>
<script type="text/javascript" language="javascript" src="<?php echo Url::siteurl() ?>includes/js/ckeditor/ckeditor.js"></script>
<form action="" method="post" id="formmenu" enctype="multipart/form-data" name="formmenu">
  <h1 class="fl"><?php echo $titulo ?></h1>
  <a class="fr back" href="<?php echo Url::adminlink("traduccion/traduce/traduce","elemento=$tabla&idiomas=$idi") ?>">Volver al listado</a>
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
    <?php 
	  $arrayContadores=array();
	foreach($camposTabla as $c)
	{
	?>
     <div class="fl w100p">
     	 <div class="fl w50p">
          <label class="cb w99p"><strong><?php echo $c->g('tituloc') ?></strong>:<br />
          <?php if($c->g('tipotrad')==3)
		  {
			  ?>
              <div style="padding:1%; width:98%;height:450px;overflow-y:scroll;border:1px solid #999;">
              <?
		  }
			  ?>
          	<?php echo $objetoorigigal->g($c->g('campo')); ?>
            <?php if($c->g('tipotrad')==3)
		  	{
			  ?>
              </div>
              <?
		 	 }
			  ?>
        	</label>
         </div>
         <div class="fl w50p">
          <label class="cb"><strong>Traducción (<?php echo $IDIOMAS[$idi]["text"] ?>)</strong>:<br />
          <?php
		  $campete=$c->g('campo');
		
		  
		   switch($c->g('tipotrad'))
		  {
			 
			  
			  case 1:
			  {
				  ?>
                  <input type="text" id="traduce<?php echo $c->g('campo') ?>" size="40" name="traduce<?php echo $c->g('campo') ?>" value="<?php echo $campotraducido->$campete ?>" />
                  <?
				  break;
			  }
			  
			  case 2:
			  {
				  ?>
                  <textarea name="traduce<?php echo $c->g('campo') ?>" cols="70" rows="5" id="traduce<?php echo $c->g('campo') ?>"><?php echo $campotraducido->$campete ?></textarea>
          
                  <?
				   break;
			  }
			   case 3:
			  {
				  $camposEditor[]="traduce".$c->g('campo');
				  
				  ?>
                  <textarea name="traduce<?php echo $c->g('campo') ?>" cols="70" rows="5" id="traduce<?php echo $c->g('campo') ?>"><?php echo $campotraducido->$campete ?></textarea>
          
                  <?
				   break;
			  }
			 case 4:
			  {
				  ?>
                  <input type="text" id="traduce<?php echo $c->g('campo') ?>" size="40" name="traduce<?php echo $c->g('campo') ?>" value="<?php echo $campotraducido->$campete ?>" /><div id="traducecontador<?php echo $c->g('campo') ?>">0</div>
                  <?
				  $arrayContadores[]=$c->g('campo');
				  break;
			  }
			  case 5:
			  {
				  ?>
                  <textarea name="traduce<?php echo $c->g('campo') ?>" cols="70" rows="5" id="traduce<?php echo $c->g('campo') ?>"><?php echo $campotraducido->$campete ?></textarea><div id="traducecontador<?php echo $c->g('campo') ?>">0</div>
          
                  <?
				   $arrayContadores[]=$c->g('campo');
				   break;
			  }
			   case 7:
			  {
				  echo $objetoorigigal->g($c->g('campo'));
	
				   break;
			  }
		  }
		  ?>
          
        </label>
         </div>
     </div>
    <?
	}
	?>
  </fieldset>
  <div class="w100p tc fl">
    <input class="cb" type="Submit" name="Submit" value="Guardar" />
  </div>
  <input type="hidden" name="controller" value="traduccion" />
  <input type="hidden" name="task" value="saveTraduccion" />
  <input type="hidden" name="cid" value="<?php echo $cid ?>" />
  <input type="hidden" name="tabla" value="<?php echo $tabla ?>" />
  <input type="hidden" name="idorigi" value="<?php echo $idorigi ?>" />
  <input type="hidden" name="idi" value="<?php echo $idi ?>" />
  
  
</form>
<script type="text/javascript">
<?php if(count($camposEditor)>0)
{ 
foreach($camposEditor as $ca)
{?>
var editor<?php echo $ca ?> = CKEDITOR.replace('<?php echo $ca ?>');
<?php 
}

}


	?>
	
$(document).ready( function() {
	<?php 
	foreach($arrayContadores as $c)
	{
	?>
	var elem = $("#traducecontador<?php echo $c ?>");
	$("#traduce<?php echo $c ?>").limiter(8000, elem);
	<?php 
	}
	?>
});
	
</script>
