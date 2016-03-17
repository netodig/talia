<?php 
global $clang,$clangp;

$oraciones= new OracionExtend();
$oraciones= $oraciones->getOracionesTrans($cid, $clang,$clangp);

?>
<h3 class="tc"><?php echo $lang->g('ORACIONES_DIVIDIDAS') ?></h3>
<?php
$i=0;
foreach($oraciones as $o)
{
	$i++;
	?>
    <label class="w100p tc">
    	<?php echo $o->g('texto')  ?><br />
    	[<?php echo $o->g('numero') ?>] <input name="oracion<?php echo $o->g('numero') ?>" id="oracion<?php echo $o->g('numero') ?>" class="oracion" type="text" value='<?php echo $o->g('textool') ?>'>  
        
        <input name="saltooracion<?php echo $o->g('numero') ?>" id="saltooracion<?php echo $o->g('numero') ?>" class="saltos" type="checkbox" <?php if($o->g('salto')){?> checked <?php } ?> value="1">
    </label>
    <?php
	
}
?>
<label  class="w100p tc">
<input name="actualizatrans" onclick="actualizaParrafoTrans()" value="<?php echo $lang->g('MOSTRAR_COMO_TEXTO_COMPLETO') ?>" type="button" />

</label>

<input type="hidden" name="cantoraciones" id="cantoraciones" value="<?php echo $i ?>" />